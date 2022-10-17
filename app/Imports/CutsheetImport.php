<?php

namespace App\Imports;

use App\Helpers\CutsheetImportHelpers;
use App\Models\Cutsheet;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithColumnLimit;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithProgressBar;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Events\AfterImport;

class CutsheetImport implements ToModel, WithHeadingRow, WithColumnLimit, WithProgressBar, WithUpserts
{
    use Importable;


    protected array $fileNameData;
    protected string $fileName;
    protected string $organization;
    protected string $fsa;
    protected string $phase;
    protected string $distributionPanel;
    protected string $fdhType;
    protected string $abbreviatedOrganization;
    //protected int $primaryKey;


    public function fromFile(array $fileNameData): CutsheetImport
    {



        $this->fileNameData = $fileNameData;
        $this->fileName = $fileNameData['fileName'];
        $this->abbreviatedOrganization = $fileNameData['abbreviatedOrganization'];
        $this->organization = $fileNameData['organization'];
        $this->phase = $fileNameData['phase'];
        $this->fsa = $fileNameData['fsa'];
        $this->fdhType = $fileNameData['fdhType'];
        $this->distributionPanel = $fileNameData['distributionPanel'];

        //var_dump($this);

        return $this;
    }


    public function headingRow(): int
    {
        return 1;
    }

    public function uniqueBy()
    {
        return ['organization','fsa','fdhType','distributionPanel','fdhPort'];
    }

    // this method gets called from CutSheetImportCommand->import -> withUpserts //
    public function model(array $row)
    {

        var_dump($row);

        if (!empty($row['id'])) {


            $cutsheetImportHelpers = new CutsheetImportHelpers;

            // Now we have create a new CutSheetImportHelpers object which we can use methods from to parse addresses

            $parsedAddress = $cutsheetImportHelpers->getAddress($row['address']);

            var_dump($parsedAddress);


             //echo("Sucessfully parsed address\n\n");


//            'organization' => $this->organization,
//            'phase' => $this->phase,
//            'fsa' => $this->fsa,
//            'fdhType' => $this->fdhType,
//            'distributionPanel' => $this->distributionPanel,
//            'splitterChassis' => $cutsheetImportHelpers->getSplitterChassis($this->distributionPanel, $row['id']),
//            'fdhPort' => $row['id'],
//            'mstID' => $row['mstid'],
//            'mstPort' => $row['mstport'],
//            'poleNumber' => $row['polenumber'],
//            'poleAddress' => $row['pole_pedaddress'],
//            //'locationID' => $row['locationid'],
//            'address' => $row['address'],
//            'streetNumber' => $parsedAddress['streetNumber'] ?? null,
//            'streetUnit' => $parsedAddress['streetUnit'] ?? null,
//            'streetName' => $parsedAddress['streetName'] ?? null,
//            'streetType' => $cutsheetImportHelpers->setStreetTypeToAbbreviatedName($parsedAddress['streetType'] ?? null),
//            'commercial' => $parsedAddress['commercial'] ?? false,
//            'residential' => $parsedAddress['residential'] ?? false,
//            'isBuilt' => (boolean)Str::of($row['address'])->before('(')->before(',')->endsWith($cutsheetImportHelpers->getValidStreetTypeListAll()) && !(boolean)Str::of($row['address'])->lower()->contains('do not build'),
//            'notes' => Str::of($row['address'])->contains(['(', ')']) ? Str::of($row['address'])->after('(')->before(')')->upper()->trim() : '',
//            'isValidAddress' => (boolean)Str::of($row['address'])->before('(')->before(',')->endsWith($cutsheetImportHelpers->getValidStreetTypeListAll()) || (boolean)Str::of($row['address'])->before('(')->before(',')->endsWith($cutsheetImportHelpers->getValidStreetNameOnlyList()),
//            'fileName' => $this->fileName
//        ]);

            // return null;

            $cutsheet_Temp = new Cutsheet([
                'abbreviatedOrganization' => $this->abbreviatedOrganization,
                'organization' => $this->organization,
                'phase' => $this->phase,
                'fsa' => $this->fsa,
                'fdhType' => $this->fdhType,
                'distributionPanel' => $this->distributionPanel,
                'splitterChassis' => $cutsheetImportHelpers->getSplitterChassis($this->distributionPanel, $row['id']),
                'fdhPort' => $row['id'],
                'mstID' => $row['mstid'],
                'mstPort' => $row['mstport'],
                'poleNumber' => $row['polenumber'],
                'poleAddress' => $row['pole_pedaddress'],
                /***************************************************/
                //   'locationID' => $row['locationid'],
                //**************************************************/
                'address' => $row['address'],
                'streetNumber' => $parsedAddress['streetNumber'] ?? null,
                'streetUnit' => $parsedAddress['streetUnit'] ?? null,
                'streetName' => $parsedAddress['streetName'] ?? null,
                'streetType' => $cutsheetImportHelpers->setStreetTypeToAbbreviatedName($parsedAddress['streetType'] ?? null),
                'commercial' => $parsedAddress['commercial'] ?? false,
                'residential' => $parsedAddress['residential'] ?? false,
                'isBuilt' => (boolean)Str::of($row['address'])->before('(')->before(',')->endsWith($cutsheetImportHelpers->getValidStreetTypeListAll()) && !(boolean)Str::of($row['address'])->lower()->contains('do not build'),
                'notes' => Str::of($row['address'])->contains(['(', ')']) ? Str::of($row['address'])->after('(')->before(')')->upper()->trim() : '',
                'isValidAddress' => (boolean)Str::of($row['address'])->before('(')->before(',')->endsWith($cutsheetImportHelpers->getValidStreetTypeListAll()) || (boolean)Str::of($row['address'])->before('(')->before(',')->endsWith($cutsheetImportHelpers->getValidStreetNameOnlyList()),
                'fileName' => $this->fileName,
                //'id' => $row['id']
            ]);

            //echo("****Inside CutSheetimport.php***\n\n");
            //dd($cutsheet_Temp);
            //var_dump($cutsheet_Temp->id);

            return $cutsheet_Temp;

            /*
            if (empty($row[0])) {
                return null;
            }

            return new Cutsheet([
                'fdhPort' => $row[0],
                'mstID' => $row[1],
                'mstPort' => $row[2],
                'poleNumber' => $row[3],
                'poleAddress' => $row[4],
                'address' => $row[5]
            ]);
            */

        } else {
            echo("empty row -> id");
            return null;
        }
    }

    public function endColumn(): string
    {
        return 'G';
    }


}
