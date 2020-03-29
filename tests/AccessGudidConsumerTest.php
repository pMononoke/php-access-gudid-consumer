<?php

declare(strict_types=1);

namespace MedicalMundi\AccessGudid\Tests;

use MedicalMundi\AccessGudid\AccessGudidConsumer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\Psr18Client;

class AccessGudidConsumerTest extends TestCase
{
    /** @test */
    public function do_parse_udi():void
    {
        $udiCode = '(01)00208851107345(17)150331';
        $expectedResponse = '{"udi":"(01)00208851107345(17)150331","issuingAgency":"GS1","di":"00208851107345","manufacturingDateOriginal":null,"expirationDateOriginal":"150331","expirationDateOriginalFormat":"YYMMDD","expirationDate":"2015-03-31","lotNumber":null,"serialNumber":null}';
        $symHttpClient = new Psr18Client();
        $sut = new AccessGudidConsumer($symHttpClient);

        $response = $sut->parseUdi($udiCode);

        self::assertSame($expectedResponse, $response);


        $udiCode2 = '=/A9999XYZ100T0944=,000025=A99971312345600=>014032=}013032&,1000000000000XYZ123';
        $expectedResponse2 = '{"udi":"=/A9999XYZ100T0944=,000025=A99971312345600=\u003e014032=}013032","issuingAgency":"ICCBBA","di":"A9999XYZ100T0944","serialNumber":"000025","donationId":"A99971312345600","expirationDateOriginalFormat":"YYYJJJ","expirationDateOriginal":"014032","expirationDate":"2014-02-01","manufacturingDateOriginalFormat":"YYYJJJ","manufacturingDateOriginal":"013032","manufacturingDate":"2013-02-01","lotNumber":null}';
        $response2 = $sut->parseUdi($udiCode2);
        self::assertSame($expectedResponse2, $response2);
    }


    /** @test */
    public function do_devices_lookup():void
    {
        $identifier = '08717648200274';
        $expectedResponse = '{"gudid":{"device":{"publicDeviceRecordKey":"a987ddbc-beba-4ae6-a807-4727f0ecaf5d","publicVersionStatus":"Update","deviceRecordStatus":"Published","publicVersionNumber":3,"publicVersionDate":"2018-07-23T00:00:00.000Z","devicePublishDate":"2015-05-08T00:00:00.000Z","deviceCommDistributionEndDate":null,"deviceCommDistributionStatus":"In Commercial Distribution","identifiers":{"identifier":[{"deviceId":"08717648200274","deviceIdType":"Primary","deviceIdIssuingAgency":"GS1","containsDINumber":null,"pkgQuantity":null,"pkgDiscontinueDate":null,"pkgStatus":null,"pkgType":null}]},"brandName":"XIENCE ALPINE","versionModelNumber":"1145350-28","catalogNumber":"1145350-28","dunsNumber":"964569052","companyName":"ABBOTT VASCULAR INC.","deviceCount":1,"deviceDescription":"XIENCE Alpine Everolimus Eluting Coronary Stent System 3.50 mm x 28 mm / Over-The-Wire","DMExempt":false,"premarketExempt":false,"deviceHCTP":false,"deviceKit":false,"deviceCombinationProduct":true,"singleUse":true,"lotBatch":true,"serialNumber":false,"manufacturingDate":false,"expirationDate":true,"donationIdNumber":false,"labeledContainsNRL":false,"labeledNoNRL":false,"MRISafetyStatus":"MR Conditional","rx":true,"otc":false,"contacts":{"customerContact":[{"phone":"+1(800)227-9902","phoneExtension":null,"email":"AV.CUSTOMERCARE@AV.ABBOTT.COM"}]},"gmdnTerms":{"gmdn":[{"gmdnPTName":"Drug-eluting coronary artery stent, non-bioabsorbable-polymer-coated","gmdnPTDefinition":"A sterile non-bioabsorbable metal tubular mesh structure covered with a non-bioabsorbable polymer and a drug coating that is designed to be implanted, via a delivery catheter, into a coronary artery (or saphenous vein graft) to maintain its patency typically in a patient with symptomatic atherosclerotic heart disease. The drug coating is slowly released and intended to inhibit restenosis by reducing vessel smooth muscle cell proliferation. Disposable devices associated with implantation may be included."}]},"productCodes":{"fdaProductCode":[{"productCode":"NIQ","productCodeName":"Coronary drug-eluting stent"}]},"deviceSizes":null,"environmentalConditions":{"storageHandling":[{"storageHandlingType":"Handling Environment Temperature","storageHandlingHigh":{"unit":"Degrees Celsius","value":"30"},"storageHandlingLow":{"unit":"Degrees Celsius","value":"15"},"storageHandlingSpecialConditionText":null},{"storageHandlingType":"Special Storage Condition, Specify","storageHandlingHigh":{"unit":"","value":""},"storageHandlingLow":{"unit":"","value":""},"storageHandlingSpecialConditionText":"Store in a dry, dark, cool place. Protect from light. Store at 25 degrees C; excursions between 15 to 30 degrees C permitted."},{"storageHandlingType":"Storage Environment Temperature","storageHandlingHigh":{"unit":"Degrees Celsius","value":"25"},"storageHandlingLow":{"unit":"Degrees Celsius","value":"25"},"storageHandlingSpecialConditionText":null}]},"sterilization":{"deviceSterile":true,"sterilizationPriorToUse":false,"methodTypes":null}}},"productCodes":[{"productCode":"NIQ","physicalState":null,"deviceClass":"3","thirdPartyFlag":"N","definition":"Stent, coronary, drug-eluting -- a metal scaffold with a drug coating placed via a delivery catheter into the coronary artery or saphenous vein graft to maintain the lumen.  The drug coating is intended to inhibit restenosis.","submissionTypeID":"2","reviewPanel":"CV","gmpExemptFlag":"N","technicalMethod":null,"reviewCode":null,"lifeSustainSupportFlag":"Y","unclassifiedReason":null,"implantFlag":"Y","targetArea":null,"regulationNumber":null,"deviceName":"Coronary Drug-Eluting Stent","medicalSpecialty":null}]}';
        $symHttpClient = new Psr18Client();
        $sut = new AccessGudidConsumer($symHttpClient);

        $response = $sut->devicesLookup($identifier);

        self::assertSame($expectedResponse, $response);
    }


    /** @test */
    public function do_devices_history():void
    {
        $identifier = '03596010535344';
        $expectedResponse = '{"history":{"5":{"primary_di":"03596010535344","publicDeviceRecordKey":"f18845df-38a8-4fc2-8d26-5cce28c8b868","publicVersionNumber":"5","publicVersionStatus":"Update","publicVersionDate":"2019-02-07T00:00:00.000Z","creationDate":"2019-02-07T16:00:53.561Z","xml":"\u003c?xml version=\'1.0\' encoding=\'UTF-8\'?\u003e\u003cdevice xmlns=\'http://www.fda.gov/cdrh/gudid\' xmlns:xsi=\'http://www.w3.org/2001/XMLSchema-instance\'\u003e\u003cpublicDeviceRecordKey\u003ef18845df-38a8-4fc2-8d26-5cce28c8b868\u003c/publicDeviceRecordKey\u003e\u003cpublicVersionStatus\u003eUpdate\u003c/publicVersionStatus\u003e\u003cdeviceRecordStatus\u003ePublished\u003c/deviceRecordStatus\u003e\u003cpublicVersionNumber\u003e5\u003c/publicVersionNumber\u003e\u003cpublicVersionDate\u003e2019-02-07\u003c/publicVersionDate\u003e\u003cdevicePublishDate\u003e2015-08-30\u003c/devicePublishDate\u003e\u003cdeviceCommDistributionEndDate\u003e2018-03-30\u003c/deviceCommDistributionEndDate\u003e\u003cdeviceCommDistributionStatus\u003eNot in Commercial Distribution\u003c/deviceCommDistributionStatus\u003e\u003cidentifiers\u003e\u003cidentifier\u003e\u003cdeviceId\u003e03596010535344\u003c/deviceId\u003e\u003cdeviceIdType\u003ePrimary\u003c/deviceIdType\u003e\u003cdeviceIdIssuingAgency\u003eGS1\u003c/deviceIdIssuingAgency\u003e\u003ccontainsDINumber xsi:nil=\"true\"/\u003e\u003cpkgQuantity xsi:nil=\"true\"/\u003e\u003cpkgDiscontinueDate xsi:nil=\"true\"/\u003e\u003cpkgStatus xsi:nil=\"true\"/\u003e\u003cpkgType xsi:nil=\"true\"/\u003e\u003c/identifier\u003e\u003c/identifiers\u003e\u003cbrandName\u003eEMPERION\u003c/brandName\u003e\u003cversionModelNumber\u003e71360949\u003c/versionModelNumber\u003e\u003ccatalogNumber\u003e71360949\u003c/catalogNumber\u003e\u003cdunsNumber\u003e109903521\u003c/dunsNumber\u003e\u003ccompanyName\u003eSmith \u0026amp; Nephew, Inc.\u003c/companyName\u003e\u003cdeviceCount\u003e1\u003c/deviceCount\u003e\u003cdeviceDescription\u003e19MM MODULAR PILOT\u003c/deviceDescription\u003e\u003cDMExempt\u003efalse\u003c/DMExempt\u003e\u003cpremarketExempt\u003efalse\u003c/premarketExempt\u003e\u003cdeviceHCTP\u003efalse\u003c/deviceHCTP\u003e\u003cdeviceKit\u003efalse\u003c/deviceKit\u003e\u003cdeviceCombinationProduct\u003efalse\u003c/deviceCombinationProduct\u003e\u003csingleUse\u003efalse\u003c/singleUse\u003e\u003clotBatch\u003etrue\u003c/lotBatch\u003e\u003cserialNumber\u003efalse\u003c/serialNumber\u003e\u003cmanufacturingDate\u003efalse\u003c/manufacturingDate\u003e\u003cexpirationDate\u003efalse\u003c/expirationDate\u003e\u003cdonationIdNumber\u003efalse\u003c/donationIdNumber\u003e\u003clabeledContainsNRL\u003efalse\u003c/labeledContainsNRL\u003e\u003clabeledNoNRL\u003efalse\u003c/labeledNoNRL\u003e\u003cMRISafetyStatus\u003eLabeling does not contain MRI Safety Information\u003c/MRISafetyStatus\u003e\u003crx\u003etrue\u003c/rx\u003e\u003cotc\u003efalse\u003c/otc\u003e\u003ccontacts\u003e\u003ccustomerContact\u003e\u003cphone\u003e+1(800)238-7538\u003c/phone\u003e\u003cphoneExtension xsi:nil=\"true\"/\u003e\u003cemail\u003eGUDID@SMITH-NEPHEW.COM\u003c/email\u003e\u003c/customerContact\u003e\u003c/contacts\u003e\u003cgmdnTerms\u003e\u003cgmdn\u003e\u003cgmdnPTName\u003eFemoral stem prosthesis trial\u003c/gmdnPTName\u003e\u003cgmdnPTDefinition\u003eA copy of a final femoral stem prosthesis designed to be used for trial reductions during hip arthroplasty to judge the correct offset, leg-length, and range of motion of the final femoral prosthesis to be implanted. It is one of a set, or a set, of graduated sizes, and is used in conjunction with femoral head trial prostheses. It is typically made of metal or polymer material and includes trial stems, trial sleeves, and trial necks. This is a reusable device intended to be sterilized prior to use.\u003c/gmdnPTDefinition\u003e\u003c/gmdn\u003e\u003c/gmdnTerms\u003e\u003cproductCodes\u003e\u003cfdaProductCode\u003e\u003cproductCode\u003eJDG\u003c/productCode\u003e\u003cproductCodeName\u003eProsthesis, hip, femoral component, cemented, metal\u003c/productCodeName\u003e\u003c/fdaProductCode\u003e\u003c/productCodes\u003e\u003cdeviceSizes/\u003e\u003cenvironmentalConditions/\u003e\u003csterilization\u003e\u003cdeviceSterile\u003efalse\u003c/deviceSterile\u003e\u003csterilizationPriorToUse\u003etrue\u003c/sterilizationPriorToUse\u003e\u003cmethodTypes\u003e\u003csterilizationMethod\u003eMoist Heat or Steam Sterilization\u003c/sterilizationMethod\u003e\u003c/methodTypes\u003e\u003c/sterilization\u003e\u003c/device\u003e"},"4":{"primary_di":"03596010535344","publicDeviceRecordKey":"f18845df-38a8-4fc2-8d26-5cce28c8b868","publicVersionNumber":"4","publicVersionStatus":"Update","publicVersionDate":"2018-07-06T00:00:00.000Z","creationDate":"2018-07-06T09:38:17.565Z","xml":"\u003c?xml version=\'1.0\' encoding=\'UTF-8\'?\u003e\u003cdevice xmlns=\'http://www.fda.gov/cdrh/gudid\' xmlns:xsi=\'http://www.w3.org/2001/XMLSchema-instance\'\u003e\u003cpublicDeviceRecordKey\u003ef18845df-38a8-4fc2-8d26-5cce28c8b868\u003c/publicDeviceRecordKey\u003e\u003cpublicVersionStatus\u003eUpdate\u003c/publicVersionStatus\u003e\u003cdeviceRecordStatus\u003ePublished\u003c/deviceRecordStatus\u003e\u003cpublicVersionNumber\u003e4\u003c/publicVersionNumber\u003e\u003cpublicVersionDate\u003e2018-07-06\u003c/publicVersionDate\u003e\u003cdevicePublishDate\u003e2015-08-30\u003c/devicePublishDate\u003e\u003cdeviceCommDistributionEndDate\u003e2018-03-30\u003c/deviceCommDistributionEndDate\u003e\u003cdeviceCommDistributionStatus\u003eNot in Commercial Distribution\u003c/deviceCommDistributionStatus\u003e\u003cidentifiers\u003e\u003cidentifier\u003e\u003cdeviceId\u003e03596010535344\u003c/deviceId\u003e\u003cdeviceIdType\u003ePrimary\u003c/deviceIdType\u003e\u003cdeviceIdIssuingAgency\u003eGS1\u003c/deviceIdIssuingAgency\u003e\u003ccontainsDINumber xsi:nil=\"true\"/\u003e\u003cpkgQuantity xsi:nil=\"true\"/\u003e\u003cpkgDiscontinueDate xsi:nil=\"true\"/\u003e\u003cpkgStatus xsi:nil=\"true\"/\u003e\u003cpkgType xsi:nil=\"true\"/\u003e\u003c/identifier\u003e\u003c/identifiers\u003e\u003cbrandName\u003eEMPERION\u003c/brandName\u003e\u003cversionModelNumber\u003e71360949\u003c/versionModelNumber\u003e\u003ccatalogNumber\u003e71360949\u003c/catalogNumber\u003e\u003cdunsNumber\u003e109903521\u003c/dunsNumber\u003e\u003ccompanyName\u003eSmith \u0026amp; Nephew, Inc.\u003c/companyName\u003e\u003cdeviceCount\u003e1\u003c/deviceCount\u003e\u003cdeviceDescription\u003e19MM MODULAR PILOT\u003c/deviceDescription\u003e\u003cDMExempt\u003efalse\u003c/DMExempt\u003e\u003cpremarketExempt\u003efalse\u003c/premarketExempt\u003e\u003cdeviceHCTP\u003efalse\u003c/deviceHCTP\u003e\u003cdeviceKit\u003efalse\u003c/deviceKit\u003e\u003cdeviceCombinationProduct\u003efalse\u003c/deviceCombinationProduct\u003e\u003csingleUse\u003efalse\u003c/singleUse\u003e\u003clotBatch\u003etrue\u003c/lotBatch\u003e\u003cserialNumber\u003efalse\u003c/serialNumber\u003e\u003cmanufacturingDate\u003efalse\u003c/manufacturingDate\u003e\u003cexpirationDate\u003efalse\u003c/expirationDate\u003e\u003cdonationIdNumber\u003efalse\u003c/donationIdNumber\u003e\u003clabeledContainsNRL\u003efalse\u003c/labeledContainsNRL\u003e\u003clabeledNoNRL\u003efalse\u003c/labeledNoNRL\u003e\u003cMRISafetyStatus\u003eLabeling does not contain MRI Safety Information\u003c/MRISafetyStatus\u003e\u003crx\u003etrue\u003c/rx\u003e\u003cotc\u003efalse\u003c/otc\u003e\u003ccontacts\u003e\u003ccustomerContact\u003e\u003cphone\u003e+1(800)238-7538\u003c/phone\u003e\u003cphoneExtension xsi:nil=\"true\"/\u003e\u003cemail\u003eGUDID@SMITH-NEPHEW.COM\u003c/email\u003e\u003c/customerContact\u003e\u003c/contacts\u003e\u003cgmdnTerms\u003e\u003cgmdn\u003e\u003cgmdnPTName\u003eFemoral stem trial prosthesis\u003c/gmdnPTName\u003e\u003cgmdnPTDefinition\u003eA copy of a final femoral stem prosthesis designed to be used for trial reductions during hip arthroplasty to judge the correct offset, leg-length, and range of motion of the final femoral prosthesis to be implanted. It is one of a set, or a set, of graduated sizes, and is used in conjunction with femoral head trial prostheses. It is typically made of metal or polymer material and includes trial stems, trial sleeves, and trial necks. This is a reusable device intended to be sterilized prior to use.\u003c/gmdnPTDefinition\u003e\u003c/gmdn\u003e\u003c/gmdnTerms\u003e\u003cproductCodes\u003e\u003cfdaProductCode\u003e\u003cproductCode\u003eJDG\u003c/productCode\u003e\u003cproductCodeName\u003eProsthesis, hip, femoral component, cemented, metal\u003c/productCodeName\u003e\u003c/fdaProductCode\u003e\u003c/productCodes\u003e\u003cdeviceSizes/\u003e\u003cenvironmentalConditions/\u003e\u003csterilization\u003e\u003cdeviceSterile\u003efalse\u003c/deviceSterile\u003e\u003csterilizationPriorToUse\u003etrue\u003c/sterilizationPriorToUse\u003e\u003cmethodTypes\u003e\u003csterilizationMethod\u003eMoist Heat or Steam Sterilization\u003c/sterilizationMethod\u003e\u003c/methodTypes\u003e\u003c/sterilization\u003e\u003c/device\u003e"},"3":{"primary_di":"03596010535344","publicDeviceRecordKey":"f18845df-38a8-4fc2-8d26-5cce28c8b868","publicVersionNumber":"3","publicVersionStatus":"Update","publicVersionDate":"2018-04-02T00:00:00.000Z","creationDate":"2018-04-03T16:25:55.631Z","xml":"\u003c?xml version=\'1.0\' encoding=\'UTF-8\'?\u003e\u003cdevice xmlns=\'http://www.fda.gov/cdrh/gudid\' xmlns:xsi=\'http://www.w3.org/2001/XMLSchema-instance\'\u003e\u003cpublicDeviceRecordKey\u003ef18845df-38a8-4fc2-8d26-5cce28c8b868\u003c/publicDeviceRecordKey\u003e\u003cpublicVersionStatus\u003eUpdate\u003c/publicVersionStatus\u003e\u003cdeviceRecordStatus\u003ePublished\u003c/deviceRecordStatus\u003e\u003cpublicVersionNumber\u003e3\u003c/publicVersionNumber\u003e\u003cpublicVersionDate\u003e2018-04-02\u003c/publicVersionDate\u003e\u003cdevicePublishDate\u003e2015-08-30\u003c/devicePublishDate\u003e\u003cdeviceCommDistributionEndDate\u003e2018-03-30\u003c/deviceCommDistributionEndDate\u003e\u003cdeviceCommDistributionStatus\u003eNot in Commercial Distribution\u003c/deviceCommDistributionStatus\u003e\u003cidentifiers\u003e\u003cidentifier\u003e\u003cdeviceId\u003e03596010535344\u003c/deviceId\u003e\u003cdeviceIdType\u003ePrimary\u003c/deviceIdType\u003e\u003cdeviceIdIssuingAgency\u003eGS1\u003c/deviceIdIssuingAgency\u003e\u003ccontainsDINumber xsi:nil=\"true\"/\u003e\u003cpkgQuantity xsi:nil=\"true\"/\u003e\u003cpkgDiscontinueDate xsi:nil=\"true\"/\u003e\u003cpkgStatus xsi:nil=\"true\"/\u003e\u003cpkgType xsi:nil=\"true\"/\u003e\u003c/identifier\u003e\u003c/identifiers\u003e\u003cbrandName\u003eEMPERION\u003c/brandName\u003e\u003cversionModelNumber\u003e71360949\u003c/versionModelNumber\u003e\u003ccatalogNumber\u003e71360949\u003c/catalogNumber\u003e\u003cdunsNumber\u003e109903521\u003c/dunsNumber\u003e\u003ccompanyName\u003eSmith \u0026amp; Nephew, Inc.\u003c/companyName\u003e\u003cdeviceCount\u003e1\u003c/deviceCount\u003e\u003cdeviceDescription\u003e19MM MODULAR PILOT\u003c/deviceDescription\u003e\u003cDMExempt\u003efalse\u003c/DMExempt\u003e\u003cpremarketExempt\u003efalse\u003c/premarketExempt\u003e\u003cdeviceHCTP\u003efalse\u003c/deviceHCTP\u003e\u003cdeviceKit\u003efalse\u003c/deviceKit\u003e\u003cdeviceCombinationProduct\u003efalse\u003c/deviceCombinationProduct\u003e\u003csingleUse\u003efalse\u003c/singleUse\u003e\u003clotBatch\u003etrue\u003c/lotBatch\u003e\u003cserialNumber\u003efalse\u003c/serialNumber\u003e\u003cmanufacturingDate\u003efalse\u003c/manufacturingDate\u003e\u003cexpirationDate\u003efalse\u003c/expirationDate\u003e\u003cdonationIdNumber\u003efalse\u003c/donationIdNumber\u003e\u003clabeledContainsNRL\u003efalse\u003c/labeledContainsNRL\u003e\u003clabeledNoNRL\u003efalse\u003c/labeledNoNRL\u003e\u003cMRISafetyStatus\u003eLabeling does not contain MRI Safety Information\u003c/MRISafetyStatus\u003e\u003crx\u003etrue\u003c/rx\u003e\u003cotc\u003efalse\u003c/otc\u003e\u003ccontacts\u003e\u003ccustomerContact\u003e\u003cphone\u003e+1(800)238-7538\u003c/phone\u003e\u003cphoneExtension xsi:nil=\"true\"/\u003e\u003cemail\u003eGUDID@SMITH-NEPHEW.COM\u003c/email\u003e\u003c/customerContact\u003e\u003c/contacts\u003e\u003cgmdnTerms\u003e\u003cgmdn\u003e\u003cgmdnPTName\u003eFemoral stem trial prosthesis\u003c/gmdnPTName\u003e\u003cgmdnPTDefinition\u003eA copy of a final femoral stem prosthesis designed to be used for trial reductions during hip arthroplasty to judge the correct offset, leg-length, and range of motion of the final femoral prosthesis to be implanted. It is one of a set of trial hip prostheses that match the different anatomical structures of the hip joint, and is used in conjunction with femoral head trial prostheses. It is typically made of metal or polymer material and includes trial stems and trial necks. This is a reusable device intended to be sterilized prior to use.\u003c/gmdnPTDefinition\u003e\u003c/gmdn\u003e\u003c/gmdnTerms\u003e\u003cproductCodes\u003e\u003cfdaProductCode\u003e\u003cproductCode\u003eJDG\u003c/productCode\u003e\u003cproductCodeName\u003eProsthesis, hip, femoral component, cemented, metal\u003c/productCodeName\u003e\u003c/fdaProductCode\u003e\u003c/productCodes\u003e\u003cdeviceSizes/\u003e\u003cenvironmentalConditions/\u003e\u003csterilization\u003e\u003cdeviceSterile\u003efalse\u003c/deviceSterile\u003e\u003csterilizationPriorToUse\u003etrue\u003c/sterilizationPriorToUse\u003e\u003cmethodTypes\u003e\u003csterilizationMethod\u003eMoist Heat or Steam Sterilization\u003c/sterilizationMethod\u003e\u003c/methodTypes\u003e\u003c/sterilization\u003e\u003c/device\u003e"},"2":{"primary_di":"03596010535344","publicDeviceRecordKey":"f18845df-38a8-4fc2-8d26-5cce28c8b868","publicVersionNumber":"2","publicVersionStatus":"Update","publicVersionDate":"2018-03-29T00:00:00.000Z","creationDate":"2018-04-02T23:44:35.355Z","xml":"\u003c?xml version=\'1.0\' encoding=\'UTF-8\'?\u003e\u003cdevice xmlns=\'http://www.fda.gov/cdrh/gudid\' xmlns:xsi=\'http://www.w3.org/2001/XMLSchema-instance\'\u003e\u003cpublicDeviceRecordKey\u003ef18845df-38a8-4fc2-8d26-5cce28c8b868\u003c/publicDeviceRecordKey\u003e\u003cpublicVersionStatus\u003eUpdate\u003c/publicVersionStatus\u003e\u003cdeviceRecordStatus\u003ePublished\u003c/deviceRecordStatus\u003e\u003cpublicVersionNumber\u003e2\u003c/publicVersionNumber\u003e\u003cpublicVersionDate\u003e2018-03-29\u003c/publicVersionDate\u003e\u003cdevicePublishDate\u003e2015-08-30\u003c/devicePublishDate\u003e\u003cdeviceCommDistributionEndDate\u003e2018-03-30\u003c/deviceCommDistributionEndDate\u003e\u003cdeviceCommDistributionStatus\u003eNot in Commercial Distribution\u003c/deviceCommDistributionStatus\u003e\u003cidentifiers\u003e\u003cidentifier\u003e\u003cdeviceId\u003e03596010535344\u003c/deviceId\u003e\u003cdeviceIdType\u003ePrimary\u003c/deviceIdType\u003e\u003cdeviceIdIssuingAgency\u003eGS1\u003c/deviceIdIssuingAgency\u003e\u003ccontainsDINumber xsi:nil=\"true\"/\u003e\u003cpkgQuantity xsi:nil=\"true\"/\u003e\u003cpkgDiscontinueDate xsi:nil=\"true\"/\u003e\u003cpkgStatus xsi:nil=\"true\"/\u003e\u003cpkgType xsi:nil=\"true\"/\u003e\u003c/identifier\u003e\u003c/identifiers\u003e\u003cbrandName\u003eEMPERION\u003c/brandName\u003e\u003cversionModelNumber\u003e71360949\u003c/versionModelNumber\u003e\u003ccatalogNumber\u003e71360949\u003c/catalogNumber\u003e\u003cdunsNumber\u003e109903521\u003c/dunsNumber\u003e\u003ccompanyName\u003eSmith \u0026amp; Nephew, Inc.\u003c/companyName\u003e\u003cdeviceCount\u003e1\u003c/deviceCount\u003e\u003cdeviceDescription\u003e19MM MODULAR PILOT\u003c/deviceDescription\u003e\u003cDMExempt\u003efalse\u003c/DMExempt\u003e\u003cpremarketExempt\u003efalse\u003c/premarketExempt\u003e\u003cdeviceHCTP\u003efalse\u003c/deviceHCTP\u003e\u003cdeviceKit\u003efalse\u003c/deviceKit\u003e\u003cdeviceCombinationProduct\u003efalse\u003c/deviceCombinationProduct\u003e\u003csingleUse\u003efalse\u003c/singleUse\u003e\u003clotBatch\u003etrue\u003c/lotBatch\u003e\u003cserialNumber\u003efalse\u003c/serialNumber\u003e\u003cmanufacturingDate\u003efalse\u003c/manufacturingDate\u003e\u003cexpirationDate\u003efalse\u003c/expirationDate\u003e\u003cdonationIdNumber\u003efalse\u003c/donationIdNumber\u003e\u003clabeledContainsNRL\u003efalse\u003c/labeledContainsNRL\u003e\u003clabeledNoNRL\u003efalse\u003c/labeledNoNRL\u003e\u003cMRISafetyStatus\u003eLabeling does not contain MRI Safety Information\u003c/MRISafetyStatus\u003e\u003crx\u003etrue\u003c/rx\u003e\u003cotc\u003efalse\u003c/otc\u003e\u003ccontacts\u003e\u003ccustomerContact\u003e\u003cphone\u003e+1(800)238-7538\u003c/phone\u003e\u003cphoneExtension xsi:nil=\"true\"/\u003e\u003cemail\u003eGUDID@SMITH-NEPHEW.COM\u003c/email\u003e\u003c/customerContact\u003e\u003c/contacts\u003e\u003cgmdnTerms\u003e\u003cgmdn\u003e\u003cgmdnPTName\u003eFemoral stem trial prosthesis\u003c/gmdnPTName\u003e\u003cgmdnPTDefinition\u003eA copy of a final femoral stem prosthesis designed to be used for trial reductions during hip arthroplasty to judge the correct offset, leg-length, and range of motion of the final femoral prosthesis to be implanted. It is one of a set of trial hip prostheses that match the different anatomical structures of the hip joint, and is used in conjunction with femoral head trial prostheses. It is typically made of metal or polymer material and includes trial stems and trial necks. This is a reusable device intended to be sterilized prior to use.\u003c/gmdnPTDefinition\u003e\u003c/gmdn\u003e\u003c/gmdnTerms\u003e\u003cproductCodes\u003e\u003cfdaProductCode\u003e\u003cproductCode\u003eJDG\u003c/productCode\u003e\u003cproductCodeName\u003eProsthesis, hip, femoral component, cemented, metal\u003c/productCodeName\u003e\u003c/fdaProductCode\u003e\u003c/productCodes\u003e\u003cdeviceSizes/\u003e\u003cenvironmentalConditions/\u003e\u003csterilization\u003e\u003cdeviceSterile\u003efalse\u003c/deviceSterile\u003e\u003csterilizationPriorToUse\u003etrue\u003c/sterilizationPriorToUse\u003e\u003cmethodTypes\u003e\u003csterilizationMethod\u003eMoist Heat or Steam Sterilization\u003c/sterilizationMethod\u003e\u003c/methodTypes\u003e\u003c/sterilization\u003e\u003c/device\u003e"}}}';
        $symHttpClient = new Psr18Client();
        $sut = new AccessGudidConsumer($symHttpClient);

        $response = $sut->devicesHistory($identifier);

        self::assertSame($expectedResponse, $response);
    }
}