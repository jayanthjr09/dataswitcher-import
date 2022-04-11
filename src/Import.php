<?php

namespace Src;

use Src\Collection\CollectionMapping;

class Import {

	/**
     * import constructor.
     *
     * @param Client $Connection
     */
    public function __construct($connection, $log)
    {
        $this->connection = $connection;
        $this->log = $log;
    }

    /**
     * import run.
     *
     * will run the import and update
     */
	public function run() {

        //getting config file which will be used to get details of collection, file name and feilds to be imported
        // TODO add validation also in config file
        // TODO add logs for each processing
        $dataConfig = json_decode(file_get_contents('data-config.json'), true);

        if ($dataConfig) {
            //looping throght the config to process each file and inserting data to collections
            foreach ($dataConfig as $key => $value) {
                $fileName = $value['fileNaame'];
                $collectionName = $value['collectionName'];

                $mapping = $this->getMapping($value['mapping']);
                $dataArray = $this->dataMapping($fileName, $mapping);
                $collections = new CollectionMapping($this->connection, $collectionName);

                //insert all data at once to one collection
                // TODO as the data is small inserting all at once if data is huge need to loop this for specific amount of data php can handle
                $collections->insertMany($dataArray);

                echo "import of ". $fileName." completed\n";
                $this->log->info("import of ". $fileName." completed");

            }
        } else {
            echo "No files to import\n";
            $this->log->info("No files to import");
        }

        //custom update/import functions which needs special treatment
        $this->updateData('invoices.csv', 'transactions');

        return true;
	}

     /**
     * import dataMapping.
     *
     * @param string $filename
     * @param array $mapping
     * @return array
     */
    public function dataMapping ($fileName, $mapping) {
        $csvData = [];
        $loopData = [];
        if (($handle = fopen("data/".$fileName, "r")) !== false) {
            $header = fgetcsv($handle, 0, ',', chr(8));
            while (($data = fgetcsv($handle, 0, ",")) !== false) {
                foreach ($data as $k => $v) {
                    if (isset($mapping[$header[$k]])) {
                        $loopData[$mapping[$header[$k]]['db']] = $v;
                    }
                }

                if (!empty($loopData)) {
                    if (isset($mapping["NULL"])) {
                        foreach ($mapping["NULL"] as $mk => $my) {
                            if (isset($my['default'])) {
                                $loopData[$my['db']] = $my['default'];
                            } else {
                                $loopData[$my['db']] = '';
                            }
                        }
                    }
                    $csvData[] = [$loopData];
                }
                $loopData = [];
            }
            fclose($handle);
        } else {
            return false;
        }
        return $csvData;
    }

    /**
     * import getMapping.
     *
     * @param array $mapping
     * @return array
     */
    public function getMapping($mapping) {
        $mappingArray = [];
        $null = [];
        foreach ($mapping as $key => $value) {
            if ($value['csv'] == "NULL") {
                if (isset($value['default'])) {
                    $null[] = ["db" => $value['db'], "default" => $value['default']];
                } else {
                    $null[] = ["db" => $value['db']];
                }
            } else {
                $mappingArray[$value['csv']] = $value;
            }
        }

        if ($null) {
            $mappingArray["NULL"] = $null;
        }

        return $mappingArray;
    }

    /**
     * import updateData.
     *
     * @param string $filename
     * @param collection $collectionName
     */
    public function updateData($fileName, $collectionName) {
        //custome mapping created for update of invoice type
        $customeMapping = [["csv" => "Journal_id", "db" => "Journal_id"], ["csv" => "Id", "db" => "id"]];
        //calling getMapping to get mapping to use for dataMapping
        $customeMapping = $this->getMapping($customeMapping);
        //calling dataMapping to get data to use for update
        $data = $this->dataMapping($fileName, $customeMapping);

        //getting collection
        $collection = new CollectionMapping($this->connection, $collectionName);

        //update based on data
        if(!empty($data)) {
            foreach ($data as $dkey => $dvalue) {
                $result = $collection->updateOne(["0.ref" => $dvalue['0']["Journal_id"]], ['$set' => ["0.type" => "I"]], ['multi' => false, 'upsert' => false]);
            }
        }
        $this->log->info("custom update of ". $fileName." completed");
        echo "custom update of ". $fileName." completed\n";
    }

}