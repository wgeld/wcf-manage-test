<?php

namespace App\Helpers;

//ini_set('max_execution_time', 300);

use App\Models\Cutsheet;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;



class CutsheetImportHelpers
{


    /**
     * Export cutsheets to excel
     *
     * @param array $cutsheets
     * @return
     */
    public function insertCutsheetToDatabase($cutsheets)
    {
        //dd($cutsheets);
        foreach ($cutsheets as $cutsheet) {

            $valuesExists = [
                'organization' => $cutsheet['organization'],
                'fsa' => $cutsheet['fsa'],
                //'distributionPanel' => $cutsheet['distributionPanel'],
                'fdhPort' => $cutsheet['fdhPort']
            ];
            $cutsheet = Cutsheet::updateOrCreate($valuesExists, $cutsheet);
        }

        return $cutsheet;
    }

    /*
     * HELPERS
     *
     */

    /**
     * Parse MST cell to get MSTID
     *
     * @param string $mstIDCell
     * @return string
     */
    public function getMSTID($mstIDCell)
    {
        return (string)Str::of($mstIDCell)->before('/')->trim();
    }

    /**
     * Parse MSTPort cell to get MSTPort
     *
     * @param string $mstPortCell
     * @return string
     */
    public function getMSTPort($mstPortCell)
    {
        $mstPort = $mstPortCell;
        if (Str::of($mstPortCell)->startsWith('Port') && Str::of($mstPortCell)->contains(':')) {
            $mstPort = (string)Str::of($mstPortCell)->after('Port')->before(':')->trim();
        } elseif (Str::of($mstPortCell)->startsWith('Port')) {
            $mstPort = (string)Str::of($mstPortCell)->after('Port')->trim();
        }

        if (Str::of($mstPortCell)->startsWith('PORT') && Str::of($mstPortCell)->contains(':')) {
            $mstPort = (string)Str::of($mstPortCell)->after('PORT')->before(':')->trim();
        } elseif (Str::of($mstPortCell)->contains('PORT')) {
            $mstPort = (string)Str::of($mstPortCell)->after('PORT')->trim();
        }
        /*
        if (Str::of($mstPortCell)->startsWith('Port')) {
            $mstPort = (string)Str::of($mstPortCell)->after('Port')->trim();
        }

        if (Str::of($mstPortCell)->contains('PORT')) {
            $mstPort = (string)Str::of($mstPortCell)->after('PORT')->trim();
        }
        */


        return $mstPort;
    }

    /**
     * Parse MSTInformation cell to get MST tail length
     *
     * @param string $mstInformationCell
     * @return string
     */
    public function getMSTTailLength($mstInformationCell)
    {
        return (string)Str::of($mstInformationCell)->before(' ')->trim();
    }

    /**
     * Parse MSTInformation cell to get number of mst ports
     *
     * @param string $mstInformationCell
     * @return string
     */
    public function getMSTNumberOfPorts($mstInformationCell)
    {
        return (string)Str::of($mstInformationCell)->after(' ')->before(' ')->trim();
    }
    /**
     * Parse pole number and pole address out of the pole information cell.
     *
     * @param string $poleInformationCell
     * @return array
     */
    public function getPoleInformation($poleInformationCell): array
    {

        $poleAddress = $this->getPoleAddress($poleInformationCell);
        $poleNumber = $this->getPoleNumber($poleInformationCell, $poleAddress);

        return [
            'poleNumber' => $poleNumber,
            'poleAddress' => $poleAddress
        ];

    }

    /**
     * Parse pole number out of the pole information cell.
     *
     * @param string $poleInformationCell
     * @param $poleAddress
     * @return string
     */
    public function getPoleNumber($poleInformationCell, $poleAddress): string
    {
        return (string)Str::of($poleInformationCell)->before($poleAddress)->trim();

    }

    /**
     * Parse pole address out of the pole information cell.
     *
     * @param string $poleInformationCell
     * @return string
     */
    public function getPoleAddress($poleInformationCell): string
    {
        $startingPoint = Str::of($poleInformationCell)->afterLast('/');
        return (string)Str::of($startingPoint)->after(' ')->trim();
    }

    /**
     * Parse address string into seperate address elements
     *
     * @param string $address
     * @return array
     */
    public function getAddress($address): array
    {
        if (Str::of($address)->contains([','])) {
            $address = (string)Str::of($address)->before(',')->trim();
        }

        $addressSplit = explode(' ', $address);

        if (Str::of(Arr::last($addressSplit))->startsWith($this->getValidStreetTypeListAll())) {

            $completeStreetNumber = $this->getCompleteStreetNumber($address);
            $streetNumber = is_numeric($this->getStreetNumber($completeStreetNumber)) ? $this->getStreetNumber($completeStreetNumber) : $completeStreetNumber;
            $streetUnit = $this->getStreetUnit($completeStreetNumber);
            $streetType = $this->getStreetType($address);
            $streetName = $this->getStreetName($address, $streetNumber,$streetUnit, $streetType);

            $streetNotes = $this->getStreetNotes($address);
            $commercial = $this->getAddressIsCommercial($address);
            $residential = $this->getAddressIsResidential($address);

            $parsedAddress = (string)Str::of($completeStreetNumber)->trim()->append(' ' . $streetName)->trim()->append(' ' . $streetType)->trim();

            //var_dump($parsedAddress);

            return [
                'streetNumber' => (string)$streetNumber,
                'streetUnit' => $streetUnit,
                'streetName' => $streetName,
                'streetType' => $streetType,
                'streetNotes' => $streetNotes,
                'commercial' => $commercial,
                'residential' => $residential,
                'address' => $parsedAddress
            ];
        }

        if (Str::of($address)->contains($this->getValidStreetNameOnlyList())) {
            $completeStreetNumber = $this->getCompleteStreetNumber($address);
            $streetNumber = is_numeric($this->getStreetNumber($completeStreetNumber)) ? $this->getStreetNumber($completeStreetNumber) : '';
            $streetUnit = $this->getStreetUnit($completeStreetNumber);
            $streetType = '';
            $streetName = $streetName = Str::of($address)->after($streetNumber)->after($streetUnit)->trim();

            $streetNotes = $this->getStreetNotes($address);
            $commercial = $this->getAddressIsCommercial($address);
            $residential = $this->getAddressIsResidential($address);

            $parsedAddress = (string)Str::of($completeStreetNumber)->trim()->append(' ' . $streetName)->trim()->append(' ' . $streetType)->trim();
            return [
                'streetNumber' => (string)$streetNumber,
                'streetUnit' => $streetUnit,
                'streetName' => $streetName,
                'streetType' => $streetType,
                'streetNotes' => $streetNotes,
                'commercial' => $commercial,
                'residential' => $residential,
                'address' => $parsedAddress
            ];
        }

        return [
            'streetNumber' => '',
            'streetUnit' => '',
            'streetName' => '',
            'streetType' => '',
            'streetNotes' => '',
            'commercial' => '',
            'residential' => '',
            'address' => $address
        ];


    }

    /**
     * Parse address string into seperate address elements
     *
     * @param string $address
     * @return array
     */
    public function getAddress2($address): array
    {
        $parsedAddress = '';
        $streetNumber = '';
        $streetUnit = '';
        $streetName = '';
        $streetType = '';
        $notes = '';
        $commercial = false;
        $residential = true;


        $validStreetTypeArray = ['STREET', 'ST', 'DRIVE', 'DR', 'AVENUE', 'AVE', 'TERRACE', 'TER', 'BOULEVARD',
            'BLVD', 'ROAD', 'RD', 'CIRCLE', 'CIR', 'LANE', 'LN', 'COURT', 'CT', 'RIDGE', 'RDG', 'PLACE', 'PL',
            'EXTENSION', 'EXT', 'STREET EXTENSION', 'ST EXT', 'DRIVE EXTENSION', 'DR EXT', 'AVENUE EXTENSION',
            'AVE EXT', 'TERRACE EXTENSION', 'TER EXT', 'BOULEVARD EXTENSION', 'BLVD EXT', 'ROAD EXTENSION',
            'RD EXT', 'CIRCLE EXTENSION', 'CIR EXT', 'LANE EXTENSION', 'LN EXT', 'COURT EXTENSION', 'CT EXT',
            'TRAIL', 'TRL', 'WAY'];

        if (Str::of($address)->contains(['VACANT LOT'])) {
            $address = (string)Str::of($address)->after('VACANT LOT')->trim();

            $addressSplit = explode(' ', $address);

            $streetNumber = 'VACANT LOT';

        } else {
            $addressSplit = explode(' ', $address);

            $streetNumber = Str::of($addressSplit[0])->trim();
        }

        if (Str::of($address)->startsWith(['NA', '(NA)'])) {
            $address = (string)Str::of($address)->after('(NA)')->trim();

            $addressSplit = explode(' ', $address);

            $streetNumber = 'NA';
        } else {
            $addressSplit = explode(' ', $address);

            $streetNumber = Str::of($addressSplit[0])->trim();
        }

        if (Str::of($address)->contains([','])) {
            $address = (string)Str::of($address)->before(',')->trim();
        }

        if (Str::of($address)->contains(['(', ')'])) {
            $notes = Str::of($address)->before(')')->after('(')->trim();

            $address = (string)Str::of($address)->before('(')->trim();

            $addressSplit = explode(' ', $address);

            if (Str::of(Arr::first($addressSplit))->contains(['(', ')'])) {
                $address = (string)Str::of($address)->after(')')->trim();
            } else {
                $address = (string)Str::of($address)->before('(')->trim();
            }
        }

        if (Str::of($streetNumber)->startsWith('C') && Str::of($streetNumber)->contains('-')) {
            $streetNumber = (string)Str::of($streetNumber)->after('C-')->trim();
        }
        if (Str::of($streetNumber)->startsWith('C')) {
            $streetNumber = (string)Str::of($streetNumber)->after('C')->trim();
        }

        if (preg_match('/[A-Za-z]/', $streetNumber) && preg_match('/[0-9]/', $streetNumber)) {
            $streetNumberSplit = preg_split('/(?<=[0-9])(?=[a-z]+)/i', $streetNumber);

            $streetNumber = (string)Str::of($streetNumberSplit[0])->append('-' . $streetNumberSplit[1])->trim();
            //$streetUnit = Str::of($streetNumberSplit[1])->trim();

        }

        if (Str::of($streetNumber)->contains('-')) {
            $streetUnitSplit = explode('-', $streetNumber);
            $streetNumber = (string)Str::of($streetUnitSplit[0])->trim();
            $streetUnit = (string)Str::of($streetUnitSplit[1])->trim();
        }

        $streetType = Arr::last($addressSplit);


        if (!empty($streetUnit)) {
            $streetName = Str::of($address)->after($streetUnit)->before($streetType)->trim();
            $address = (string)Str::of($streetNumber)->append('-' . $streetUnit)->append(' ' . $streetName)->append(' ' . $streetType);
        } else {
            $streetName = Str::of($address)->after($streetNumber)->before($streetType)->trim();
            $address = (string)Str::of($streetNumber)->append(' ' . $streetName)->append(' ' . $streetType);
        }

        return [
            'streetNumber' => (string)$streetNumber,
            'streetUnit' => (string)$streetUnit,
            'streetName' => (string)$streetName,
            'streetType' => (string)$streetType,
            'notes' => (string)$notes,
            'commercial' => $commercial,
            'residential' => $residential,
            'address' => (string)$address
        ];
    }

    /**
     * Parse address string into seperate address elements
     *
     * @param string $address
     * @return array
     */
    public function getAddress1($address): array
    {
        $parsedAddress = '';
        $streetNumber = '';
        $streetUnit = '';
        $streetName = '';
        $streetType = '';
        $notes = '';
        $commercial = false;
        $residential = true;

        $validStreetTypeArray = ['STREET', 'ST', 'DRIVE', 'DR', 'AVENUE', 'AVE', 'TERRACE', 'TER', 'BOULEVARD', 'BLVD', 'ROAD', 'RD', 'CIRCLE', 'CIR', 'LANE', 'LN', 'COURT', 'CT', 'RIDGE', 'RDG', 'PLACE', 'PL', 'EXTENSION', 'EXT', 'STREET EXTENSION', 'ST EXT', 'DRIVE EXTENSION', 'DR EXT', 'AVENUE EXTENSION', 'AVE EXT', 'TERRACE EXTENSION', 'TER EXT', 'BOULEVARD EXTENSION', 'BLVD EXT', 'ROAD EXTENSION', 'RD EXT', 'CIRCLE EXTENSION', 'CIR EXT', 'LANE EXTENSION', 'LN EXT', 'COURT EXTENSION', 'CT EXT', 'TRAIL', 'TRL', 'WAY'];

        if (Str::of($address)->contains(['(', ')'])) {
            $notes = Str::of($address)->before(')')->after('(')->trim();

            $address = (string)Str::of($address)->before('(')->trim();
        }


        if (Str::of($address)->contains(['VACANT LOT'])) {
            $address = (string)Str::of($address)->after('VACANT LOT')->trim();

            $addressSplit = explode(' ', $address);

            $streetNumber = 'VACANT LOT';

        } else {
            $addressSplit = explode(' ', $address);

            $streetNumber = Str::of($addressSplit[0])->trim();
        }

        if (Str::of($streetNumber)->contains('-')) {
            $streetUnitSplit = explode('-', $streetNumber);
            $streetNumber = Str::of($streetUnitSplit[0])->trim();
            $streetUnit = Str::of($streetUnitSplit[1])->trim();
        }
        if (Str::of($streetNumber)->startsWith('C')) {
            $streetNumber = Str::of($streetNumber)->after('C')->trim();
            $commercial = true;
            $residential = false;
        }
        //the street name consists of a direction and is two words otherwise its a direction with one word
        if (count($addressSplit) === 5) {

            switch (Str::of($addressSplit[1])->trim()) {
                case 'NORTH':
                    $addressSplit[1] = 'N';
                    break;
                case 'SOUTH':
                    $addressSplit[1] = 'S';
                    break;
                case 'EAST':
                    $addressSplit[1] = 'E';
                    break;
                case 'WEST':
                    $addressSplit[1] = 'W';
                    break;
            }
            $streetName = Str::of($addressSplit[1])->trim()->append(' ' . Str::of($addressSplit[2])->trim())->append(' ' . Str::of($addressSplit[3])->trim());
            $streetType = Str::of($addressSplit[4])->trim();

        } elseif (count($addressSplit) === 4) {
            switch (Str::of($addressSplit[1])->trim()) {
                case 'NORTH':
                    $addressSplit[1] = 'N';
                    break;
                case 'SOUTH':
                    $addressSplit[1] = 'S';
                    break;
                case 'EAST':
                    $addressSplit[1] = 'E';
                    break;
                case 'WEST':
                    $addressSplit[1] = 'W';
                    break;
            }
            $streetName = Str::of($addressSplit[1])->trim()->append(' ' . Str::of($addressSplit[2])->trim());
            $streetType = Str::of($addressSplit[3])->trim();
        } elseif (count($addressSplit) === 3) {

            $streetName = Str::of($addressSplit[1])->trim();
            $streetType = Str::of($addressSplit[2])->trim();
        }

        return [
            'streetNumber' => (string)$streetNumber,
            'streetUnit' => (string)$streetUnit,
            'streetName' => (string)$streetName,
            'streetType' => (string)$streetType,
            'notes' => (string)$notes,
            'commercial' => $commercial,
            'residential' => $residential,
            'address' => (string)$address
        ];
    }

    /**
     * Removes any empty rows from the rows array
     *
     * @param array $rows
     * @return array
     */
    public function cleanRows($rows)
    {

        $removableStringArray = ['Customer', 'PORT ID', 'Splitter Port ID'];

        $rowIndex = 0;
        foreach ($rows as $cells) { //rows
            //dd(Arr::flatten($cells));
            if (Str::of($cells[0])->contains($removableStringArray)) {
                unset($rows[$rowIndex]);
            }
            /*
             //use this if you know addressees are in the cutsheets
            if (empty($cells[0]) || Str::of($cells[0])->contains($removableStringArray)) {
                unset($rows[$rowIndex]);
            }
            */
            $rowIndex++;
        }
        $rowIndex = 1;
        foreach ($rows as $cells) { //rows
            //dd(Arr::flatten($cells));
            if (empty($cells[1]) || Str::of($cells[1])->contains($removableStringArray)) {
                unset($rows[$rowIndex]);
            }
            $rowIndex++;
        }
        return array_values($rows);
    }

    /**
     * Removes any empty columns from the columns array
     *
     * @param array $columns
     * @return array|string
     */
    public function cleanColumns($columns)
    {
        $columnIndex = 0;
        foreach ($columns as $cell) { //rows

            if (empty($cell)) {
                unset($columns[$columnIndex]);
            }
            $columnIndex++;
        }
        return array_values($columns);
    }

    /**
     * Sets pole and mst information to empty data. this is a quick workaround TODO: work on improving the looping in the main function
     * In the same cleanup it checks if the record exists and will unset the correctAddress array keys because it will only be set on the first creation.
     *
     * @param array $parsedData
     * @return array|string
     */
    public function cleanParsedData($parsedData)
    {

        //dd($parsedData);
        foreach ($parsedData as $index => $value) {
            $isValidAddress = data_get($parsedData[$index], 'addressIsValidAddress');
            if (!$isValidAddress) {
                data_set($parsedData[$index], 'isSinglePortMST', false);
                data_set($parsedData[$index], 'poleNumber', '');
                data_set($parsedData[$index], 'poleAddress', '');
                data_set($parsedData[$index], 'mstInformationCell', '');
                data_set($parsedData[$index], 'mstTailLength', '');
                data_set($parsedData[$index], 'mstNumberOfPorts', '');
                data_set($parsedData[$index], 'poleInformationCell', '');
            }
            if(!isset($parsedData[$index]['organization']) || empty($parsedData[$index]['organization'])){
                //dd($index);
                $parsedData[$index]['index'] = $index;
                dd($parsedData[$index]);
            }
            //print_r($index);
            //print_r($value);
            $exists = Cutsheet::where('organization', $parsedData[$index]['organization'])
                ->where('fsa', $parsedData[$index]['fsa'])
                ->where('distributionPanel', $parsedData[$index]['distributionPanel'])
                ->where('fdhPort', $parsedData[$index]['fdhPort'])
                ->exists();

            if ($exists) {
                Arr::pull($parsedData[$index], 'correctAddress');
                Arr::pull($parsedData[$index], 'correctStreetNumber');
                Arr::pull($parsedData[$index], 'correctStreetUnit');
                Arr::pull($parsedData[$index], 'correctStreetName');
                Arr::pull($parsedData[$index], 'correctStreetType');
                Arr::pull($parsedData[$index], 'correctCommercial');
                Arr::pull($parsedData[$index], 'correctResidential');
                Arr::pull($parsedData[$index], 'correctAddressIsValidAddress');

                //unset($data['correctAddress'], $data['correctStreetNumber'], $data['correctStreetUnit'], $data['correctStreetName'], $data['correctStreetType'], $data['correctCommercial'], $data['correctResidential']);
                //dd($data);
            }
        }

        return $parsedData;
    }

    /**
     * Parse the cutsheet file name to get relevant data
     *
     * @param string $fileName
     * @return array
     */
    public
    function getFileNameData($fileName)
    {

        echo("****************************** filename:" . $fileName . "*********************\n");

        $abbreviatedOrganization = Str::of($fileName)->before('-');

        echo("****************************** abbr org:" . $abbreviatedOrganization . "*********************\n");

        $organization = $this->getOrganizationNameFromFilename($abbreviatedOrganization);

        echo("****************************** org:" . $organization . "*********************\n");




        //get fdhType from filename
        if (Str::of($fileName)->contains('CAB')) {
            $fdhType = 'CAB';
        } elseif (Str::of($fileName)->contains('OFS')) {
            $fdhType = 'OFS';
        } else {
            $fdhType = '';
        }



        //get fsa from filename
        if (Str::of($fileName)->contains('FSA')) {
            $fsa = Str::of($fileName)->after('FSA')->before('_');
        } else {
            $fsa = '';
        }

        if (Str::of($fileName)->contains('Panel')) {
            $distributionPanel = Str::of($fileName)->after('Panel')->before('_');
        } else {
            $distributionPanel = '';
        }

        if (Str::of($abbreviatedOrganization)->contains(['OT', 'OTIS'])) {
            $phase = Str::of($fileName)->after('Phase')->before('_');
        } else {
            $phase = '';
        }

        $fileNameDataObject = [
            'abbreviatedOrganization' => (string)$abbreviatedOrganization,
            'organization' => $organization,
            'phase' => (string)$phase,
            'fsa' => (string)$fsa,
            'fdhType' => $fdhType,
            'distributionPanel' => (string)$distributionPanel,
            'fileName' => (string)$fileName
        ];

        //var_dump($fileNameDataObject);

        //return (string)Str::of($poleInformationCell)->after(' ')->trim();

        return $fileNameDataObject;

    }

    /**
     * Parse the cutsheet file name to get organization name
     *
     * @param string $fileName
     * @return string
     */
    public
    function getOrganizationNameFromFilename($abbreviatedOrganization)
    {
        switch ($abbreviatedOrganization) {
            case 'AS':
                $organization = 'ASHFIELD';
                break;
            case 'BK':
                $organization = 'BECKET';
                break;
            case 'BL':
                $organization = 'BLANDFORD';
                break;
            case 'CM':
                $organization = 'CHARLEMONT';
                break;
            case 'CF':
                $organization = 'CHESTERFIELD';
                break;
            case 'CO':
                $organization = 'COLRAIN';
                break;
            case 'CU':
                $organization = 'CUMMINGTON';
                break;
            case 'HE':
                $organization = 'HEATH';
                break;
            case 'GO':
                $organization = 'GOSHEN';
                break;
            case 'LD':
                $organization = 'LEYDEN';
                break;
            case 'NA':
                $organization = 'NEW ASHFORD';
                break;
            case 'NS':
                $organization = 'NEW SALEM';
                break;
            case 'OT':
            case 'Otis':
                $organization = 'OTIS';
                break;
            case 'PF':
                $organization = 'PLAINFIELD';
                break;
            case 'RW':
                $organization = 'ROWE';
                break;
            case 'SB':
                $organization = 'SHUTESBURY';
                break;
            case 'WA':
                $organization = 'WASHINGTON';
                break;
            case 'WE':
                $organization = 'WENDELL';
                break;
            case 'WI':
                $organization = 'WINDSOR';
                break;
            case 'WCF':
                $organization = 'WESTFIELD';
                break;
            default:
                $organization = 'NONE';
                break;
        }
        return $organization;
    }

    /**
     * Sets street type to the abbreviated version if its expanded
     *
     * @param string $streetType
     * @return string
     */
    public
    function setStreetTypeToAbbreviatedName($streetType)
    {
        switch ($streetType) {
            case 'STREET':
                $streetType = 'ST';
                break;
            case 'DRIVE':
                $streetType = 'DR';
                break;
            case 'AVENUE':
                $streetType = 'AVE';
                break;
            case 'TERRACE':
                $streetType = 'TER';
                break;
            case 'BOULEVARD':
                $streetType = 'BLVD';
                break;
            case 'ROAD':
                $streetType = 'RD';
                break;
            case 'CIRCLE':
                $streetType = 'CIR';
                break;
            case 'LANE':
                $streetType = 'LN';
                break;
            case 'COURT':
                $streetType = 'CT';
                break;
            case 'RIDGE':
                $streetType = 'RDG';
                break;
            case 'PLACE':
                $streetType = 'PL';
                break;
            case 'EXTENSION':
                $streetType = 'EXT';
                break;
            case 'STREET EXTENSION':
                $streetType = 'ST EXT';
                break;
            case 'DRIVE EXTENSION':
                $streetType = 'DR EXT';
                break;
            case 'AVENUE EXTENSION':
                $streetType = 'AVE EXT';
                break;
            case 'TERRACE EXTENSION':
                $streetType = 'TER EXT';
                break;
            case 'BOULEVARD EXTENSION':
                $streetType = 'BLVD EXT';
                break;
            case 'ROAD EXTENSION':
                $streetType = 'RD EXT';
                break;
            case 'CIRCLE EXTENSION':
                $streetType = 'CIR EXT';
                break;
            case 'LANE EXTENSION':
                $streetType = 'LN EXT';
                break;
            case 'COURT EXTENSION':
                $streetType = 'CT EXT';
                break;
            case 'TRAIL':
                $streetType = 'TRL';
                break;
            case 'WAY':
                $streetType = 'WY';
                break;
            case 'POINT':
                $streetType = 'PT';
                break;
            case 'OLD ROUTE 9':
                $streetType = 'OLD RTE 9';
                break;
        }
        return $streetType;
    }

    /**
     * Sets street type to the abbreviated version if its expanded
     *
     * @param string $streetType
     * @return string
     */
    public
    function setStreetTypeToFullName($streetType)
    {
        switch ($streetType) {
            case 'ST':
                $streetType = 'STREET';
                break;
            case 'DR':
                $streetType = 'DRIVE';
                break;
            case 'AVE':
                $streetType = 'AVENUE';
                break;
            case 'TER':
                $streetType = 'TERRACE';
                break;
            case 'BLVD':
                $streetType = 'BOULEVARD';
                break;
            case 'RD':
                $streetType = 'ROAD';
                break;
            case 'CIR':
                $streetType = 'CIRCLE';
                break;
            case 'LN':
                $streetType = 'LANE';
                break;
            case 'CT':
                $streetType = 'COURT';
                break;
            case 'RDG':
                $streetType = 'RIDGE';
                break;
            case 'PL':
                $streetType = 'PLACE';
                break;
            case 'EXT':
                $streetType = 'EXTENSION';
                break;
            case 'ST EXT':
                $streetType = 'STREET EXTENSION';
                break;
            case 'DR EXT':
                $streetType = 'DRIVE EXTENSION';
                break;
            case 'AVE EXT':
                $streetType = 'AVENUE EXTENSION';
                break;
            case 'TER EXT':
                $streetType = 'TERRACE EXTENSION';
                break;
            case 'BLVD EXT':
                $streetType = 'BOULEVARD EXTENSION';
                break;
            case 'RD EXT':
                $streetType = 'ROAD EXTENSION';
                break;
            case 'CIR EXT':
                $streetType = 'CIRCLE EXTENSION';
                break;
            case 'LN EXT':
                $streetType = 'LANE EXTENSION';
                break;
            case 'CT EXT':
                $streetType = 'COURT EXTENSION';
                break;
            case 'OLD RTE 9':
                $streetType = 'OLD ROUTE 9';
                break;
        }
        return $streetType;
    }

    /**
     * Get the street number from the address string
     *
     * @param string $address
     * @return Stringable|string
     */
    public
    function getCompleteStreetNumber($address)
    {
        if (Str::of($address)->startsWith('C-')) {
            //$address = (string)Str::of($address)->replace('C-','C')->trim();
            $address = (string)Str::of($address)->after('C-')->trim();
        } elseif (Str::of($address)->startsWith('C')) {
            $address = (string)Str::of($address)->after('C')->trim();
        }
        if (Str::of($address)->startsWith(['VACANT LOT'])) {
            $completeStreetNumber = 'VACANT LOT';
        } elseif (Str::of($address)->startsWith(['NA'])) {
            $completeStreetNumber = 'NA';
        } elseif (Str::of($address)->startsWith(['(NA)'])) {
            $address = (string)Str::of($address)->after('(NA)')->trim();

            $addressSplit = explode(' ', $address);

            $completeStreetNumber = Str::of($addressSplit[0])->trim();
        } else {
            $addressSplit = explode(' ', $address);

            $completeStreetNumber = Str::of($addressSplit[0])->trim();
        }
        if (preg_match('/(?<=[0-9])(?=[a-z]+)/i', $completeStreetNumber)) {
            $streetNumberSplit = preg_split('/(?<=[0-9])(?=[a-z]+)/i', $completeStreetNumber);

            $completeStreetNumber = Str::of($streetNumberSplit[0])->trim()->append('-' . $streetNumberSplit[1])->trim();
            //$streetUnit = Str::of($streetNumberSplit[1])->trim();
        }

        /*
        if (preg_match('/[0-9]/', $completeStreetNumber) && preg_match('/[A-Za-z]/', $completeStreetNumber)) {
            $streetNumberSplit = preg_split('/(?<=[0-9])(?=[a-z]+)/i', $completeStreetNumber);

            $completeStreetNumber = Str::of($streetNumberSplit[0])->trim()->append('-' . $streetNumberSplit[1])->trim();
            //$streetUnit = Str::of($streetNumberSplit[1])->trim();

        }
        */

        return (string)$completeStreetNumber;
    }

    /**
     * Get the street number from the address string
     *
     * @param string $completeStreetNumber
     * @return Stringable|string
     */
    public
    function getStreetNumber($completeStreetNumber)
    {

        if (Str::of($completeStreetNumber)->startsWith('C-')) {
            $completeStreetNumber = (string)Str::of($completeStreetNumber)->after('C-')->trim();

        } elseif (Str::of($completeStreetNumber)->startsWith('C')) {
            $completeStreetNumber = (string)Str::of($completeStreetNumber)->after('C')->trim();
        }

        if (Str::of($completeStreetNumber)->contains('-')) {
            $streetUnitSplit = explode('-', $completeStreetNumber);
            $streetNumber = Str::of($streetUnitSplit[0])->trim();

        } else {

            $streetNumber = Str::of($completeStreetNumber)->trim();
        }

        return (string)$streetNumber;
    }

    /**
     * Get the street unit from the address string
     *
     * @param string $completeStreetNumber
     * @return string
     */
    public
    function getStreetUnit($completeStreetNumber): string
    {
        if (Str::of($completeStreetNumber)->contains('-')) {
            $streetUnitSplit = explode('-', $completeStreetNumber);

            $streetUnit = Str::of($streetUnitSplit[1])->trim();
        } else {
            $streetUnit = '';
        }


        return (string)$streetUnit;
    }

    /**
     * Get the street name from the address string
     *
     * @param string $address
     * @param $streetNumber
     * @param $streetUnit
     * @param string $streetType
     * @return string
     */
    public
    function getStreetName($address, $streetNumber, $streetUnit, $streetType): string
    {
        $streetName = Str::of($address)->after($streetNumber)->after($streetUnit)->beforeLast($streetType)->trim();
        return (string)$streetName;
    }

    /**
     * Get the street type from the address string
     * TODO: Find a way to deal with multiple word street types
     *
     * @param string $address
     * @return string
     */
    public
    function getStreetType($address): string
    {

        $addressSplit = explode(' ', $address);
        $streetType = Arr::last($addressSplit);

        return (string)$streetType;
    }

    /**
     * Get the street notes from the address string
     *
     * @param string $address
     * @return string
     */
    public
    function getStreetNotes($address): string
    {

        if (Str::of($address)->contains(['(', ')'])) {
            $streetNotes = Str::of($address)->after('(')->before(')')->trim();

        } else {
            $streetNotes = '';
        }


        return (string)$streetNotes;
    }

    /**
     * Check if the address is a commercial address from the address string
     *
     * @param string $address
     * @return boolean
     */
    public
    function getAddressIsCommercial($address): bool
    {
        if (Str::of($address)->startsWith('C')) {
            $addressIsCommercial = true;
        } else {
            $addressIsCommercial = false;
        }

        return $addressIsCommercial;
    }

    /**
     * Check if the address is a residential address from the address string
     *
     * @param string $address
     * @return boolean
     */
    public
    function getAddressIsResidential($address): bool
    {
        if (Str::of($address)->startsWith('C')) {
            $addressIsResidential = false;
        } else {
            $addressIsResidential = true;
        }

        return $addressIsResidential;
    }

    /**
     * Get an array of valid street types that are the abbreviated street types
     *
     *
     * @return string[]
     */
    public
    function getValidStreetTypeListAbbreviated()
    {
        return ['ST', 'DR', 'AVE', 'TER',
            'BLVD', 'RD', 'CIR', 'LN', 'CT', 'RDG', 'PL',
            'EXT', 'ST EXT', 'DR EXT',
            'AVE EXT', 'TER EXT', 'BLVD EXT',
            'RD EXT', 'CIR EXT', 'LN EXT', 'CT EXT',
            'TRL', 'WY', 'PT', 'BLF','BLFS'];
    }
    /**
     * Get an array of valid street types that are the abbreviated street types with two words
     *
     *
     * @return string[]
     */
    public
    function getValidStreetTypeListAbbreviatedTwoWords()
    {
        return ['ST EXT', 'DR EXT',
            'AVE EXT', 'TER EXT', 'BLVD EXT',
            'RD EXT', 'CIR EXT', 'LN EXT',
            'CT EXT'];
    }
    /**
     * Get an array of valid street types that are the full street types
     *
     *
     * @return string[]
     */
    public
    function getValidStreetTypeListLong()
    {
        return ['STREET', 'DRIVE', 'AVENUE', 'TERRACE', 'BOULEVARD',
            'ROAD', 'CIRCLE', 'LANE', 'COURT', 'RIDGE', 'PLACE',
            'EXTENSION', 'STREET EXTENSION', 'DRIVE EXTENSION', 'AVENUE EXTENSION',
            'TERRACE EXTENSION', 'BOULEVARD EXTENSION', 'ROAD EXTENSION',
            'CIRCLE EXTENSION', 'LANE EXTENSION', 'COURT EXTENSION',
            'TRAIL', 'WAY', 'POINT','BLUFF','BLUFFS'];
    }

    /**
     * Get an array of all valid street types
     *
     *
     * @return string[]
     */
    public
    function getValidStreetTypeListAll()
    {
        return ['STREET', 'ST', 'DRIVE', 'DR', 'AVENUE', 'AVE', 'TERRACE', 'TER', 'BOULEVARD',
            'BLVD', 'ROAD', 'RD', 'CIRCLE', 'CIR', 'LANE', 'LN', 'COURT', 'CT', 'RIDGE', 'RDG', 'PLACE', 'PL',
            'EXTENSION', 'EXT', 'STREET EXTENSION', 'ST EXT', 'DRIVE EXTENSION', 'DR EXT', 'AVENUE EXTENSION',
            'AVE EXT', 'TERRACE EXTENSION', 'TER EXT', 'BOULEVARD EXTENSION', 'BLVD EXT', 'ROAD EXTENSION',
            'RD EXT', 'CIRCLE EXTENSION', 'CIR EXT', 'LANE EXTENSION', 'LN EXT', 'COURT EXTENSION', 'CT EXT',
            'TRAIL', 'TRL', 'WAY', 'POINT', 'PT', 'NORTH','BLUFF','BLUFFS'];
    }
    /**
     * Get an array of all valid street types
     *
     *
     * @return string[]
     */
    public
    function getValidStreetNameOnlyList()
    {
        return ['HIGH ST HILL','OLD RTE 9','OLD ROUTE 9',];
    }
    /**
     * Get the splitter chassis based on fdh port
     *
     * @param string $distributionPanel ,$fdhPort
     * @return string
     */
    public
    function getSplitterChassis($distributionPanel, $fdhPort)
    {
        if ($fdhPort >= 1 && $fdhPort <= 144) {
            switch ($distributionPanel) {
                case '01':
                case '02':
                    $splitterChassis = '1L';
                    break;
                case '03':
                case '04':
                    $splitterChassis = '2L';
                    break;
                case '05':
                case '06':
                    $splitterChassis = '3L';
                    break;
                case '07':
                case '08':
                    $splitterChassis = '4L';
                    break;
                case '09':
                case '10':
                    $splitterChassis = '5L';
                    break;
                case '11':
                case '12':
                    $splitterChassis = '6L';
                    break;
                case '13':
                case '14':
                    $splitterChassis = '7L';
                    break;
                case '15':
                case '16':
                    $splitterChassis = '8L';
                    break;
                case '17':
                case '18':
                    $splitterChassis = '9L';
                    break;
                case '19':
                case '20':
                    $splitterChassis = '10L';
                    break;
                case '21':
                case '22':
                    $splitterChassis = '11L';
                    break;
                case '23':
                case '24':
                    $splitterChassis = '12L';
                    break;
                case '25':
                case '26':
                    $splitterChassis = '13L';
                    break;
                case '27':
                case '28':
                    $splitterChassis = '14L';
                    break;
                case '29':
                case '30':
                    $splitterChassis = '15L';
                    break;
                default:
                    $splitterChassis = '';
                    break;
            }
        } elseif ($fdhPort >= 145 && $fdhPort <= 288) {
            switch ($distributionPanel) {
                case '01':
                case '02':
                    $splitterChassis = '1R';
                    break;
                case '03':
                case '04':
                    $splitterChassis = '2R';
                    break;
                case '05':
                case '06':
                    $splitterChassis = '3R';
                    break;
                case '07':
                case '08':
                    $splitterChassis = '4R';
                    break;
                case '09':
                case '10':
                    $splitterChassis = '5R';
                    break;
                case '11':
                case '12':
                    $splitterChassis = '6R';
                    break;
                case '13':
                case '14':
                    $splitterChassis = '7R';
                    break;
                case '15':
                case '16':
                    $splitterChassis = '8R';
                    break;
                case '17':
                case '18':
                    $splitterChassis = '9R';
                    break;
                case '19':
                case '20':
                    $splitterChassis = '10R';
                    break;
                case '21':
                case '22':
                    $splitterChassis = '11R';
                    break;
                case '23':
                case '24':
                    $splitterChassis = '12R';
                    break;
                case '25':
                case '26':
                    $splitterChassis = '13R';
                    break;
                case '27':
                case '28':
                    $splitterChassis = '14R';
                    break;
                case '29':
                case '30':
                    $splitterChassis = '15R';
                    break;
                default:
                    $splitterChassis = '';
                    break;
            }
        }

        if (!isset($splitterChassis)) {
            $splitterChassis = 'BLANK';
        }
        return $splitterChassis;
    }
}
