@extends('layouts.app')

@section('content')
<div class="container">
    <div class="panel-body">
        <form class="form-horizontal" role="form" method="post" action="/home">
            {{ csrf_field() }}
            @if (count($errors))
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
            @endif
            <div class="container">
                <fieldset>
                    <legend>ShippingType</legend>
                    <div class="text-center">
                        <span class="col-sm-3"><input type="radio" name="thirdParty" value="UShip" checked> UShip</span>
                        <span class="col-sm-3"><input type="radio" name="thirdParty" value="UPS"> UPS</span>
                        <span class="col-sm-3"><input type="radio" name="thirdParty" value="FedEx"> FedEx</span>
                        <span class="col-sm-3"><input type="radio" name="thirdParty" value="FREIGHTQUOTE"> FREIGHTQUOTE</span>
                    </div>
                </fieldset>
                <fieldset class="route">
                    <legend class="route-legend">Route:</legend>
                    <div class="itemdiv" id="itemdiv">
                        <div class="first col-sm-6" id="first">
                            <fieldset>
                                <legend>Shipper / ShipFrom:</legend>
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label>streetAddress:</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input name="item[origin][streetAddress]" type="text" class="input"></input>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">alternateStreetAddress:</label>
                                    <div class="col-md-8">
                                        <input name="item[origin][alternateStreetAddress]" type="text" class="input"></input>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">majorMunicipality:</label>
                                    <div class="col-md-8">
                                        <input name="item[origin][majorMunicipality]" type="text" class="input"></input>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">postalCode:</label>
                                    <div class="col-md-8">
                                        <input name="item[origin][postalCode]" type="text" class="input"></input>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">stateProvince:</label>
                                    <div class="col-md-8">
                                        <input name="item[origin][stateProvince]" type="text" class="input"></input>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">country:</label>
                                    <div class="col-md-8">
                                        <input name="item[origin][country]" type="text" class="input"></input>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">AddressType:</label>
                                    <div class="col-md-8">
                                        <select name="item[origin][AddressType]" style="width: 100%;">
                                            <option value="Residence">Residence</option>
                                            <option value="BusinessWithLoadingDockOrForklift">Business (with loading dock or forklift)</option>
                                            <option value="BusinessWithoutLoadingDockOrForklift">Business (without loading dock or forklift)</option>
                                            <option value="Port">Port</option>
                                            <option value="ConstructionSite">ConstructionSite</option>
                                            <option value="TradeShowOrConvention">Trade Show / Convention Center</option>
                                            <option value="StorageFacility">Storage Facility</option>
                                            <option value="MilitaryBase">Military Base</option>
                                            <option value="StorageFacility">Storage Facility</option>
                                            <option value="Airport">Airport</option>
                                            <option value="OtherSecuredLocation">Other Secured or Limited Access Location</option>
                                        </select>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend>TimeFrame:</legend>
                                <div class="form-group row">
                                    <label class="col-md-4">Earliest Arrival:</label>
                                    <div class="col-md-8">
                                        <input name="item[origin][earliestArrival]" type="date" class="input"></input>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">Latest Arrival:</label>
                                    <div class="col-md-8">
                                        <input name="item[origin][latestArrival]" type="date" class="input"></input>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">timeFrameType:</label>
                                    <div class="col-md-8">
                                        <input type="radio" name="item[origin][timeFrameType]" value="on" checked> On
                                        <input type="radio" name="item[origin][timeFrameType]" value="between"> Between
                                        <input type="radio" name="item[origin][timeFrameType]" value="daysdelay"> DaysDelay<br>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend>Contact:</legend>
                                <div class="form-group row">
                                    <label class="col-md-4">name:</label>
                                    <div class="col-md-8">
                                        <input name="item[origin][name]" type="text" class="input"></input>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">companyName:</label>
                                    <div class="col-md-8">
                                        <input name="item[origin][companyName]" type="text" class="input"></input>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">phoneNumber:</label>
                                    <div class="col-md-8">
                                        <input name="item[origin][phoneNumber]" type="tel" class="input"></input>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend>UShip Attribute:</legend>
                                <div class="form-group row">
                                    <label class="col-md-4">Inside:</label>
                                    <div class="col-md-8">
                                        <input type="radio" name="item[origin][inside]" value="true"> Yes
                                        <input type="radio" name="item[origin][inside]" value="false" checked> No<br>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">LiftgateRequired:</label>
                                    <div class="col-md-8">
                                        <input type="radio" name="item[origin][liftgateRequired]" value="true"> Yes
                                        <input type="radio" name="item[origin][liftgateRequired]" value="false" checked> No<br>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">callBeforeArrival:</label>
                                    <div class="col-md-8">
                                        <input type="radio" name="item[origin][callBeforeArrival]" value="true" checked> Yes
                                        <input type="radio" name="item[origin][callBeforeArrival]" value="false"> No<br>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">appointmentRequired:</label>
                                    <div class="col-md-8">
                                        <input type="radio" name="item[origin][appointmentRequired]" value="true" checked> Yes
                                        <input type="radio" name="item[origin][appointmentRequired]" value="false"> No<br>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend>Freightquote Attribute:</legend>
                                <div class="form-group row">
                                    <label class="col-md-4">HasLoadingDock:</label>
                                    <div class="col-md-8">
                                        <input type="radio" name="item[origin][hasLoadingDock]" value="true"> Yes
                                        <input type="radio" name="item[origin][hasLoadingDock]" value="false" checked> No<br>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">IsConstructionSite:</label>
                                    <div class="col-md-8">
                                        <input type="radio" name="item[origin][isConstructionSite]" value="true"> Yes
                                        <input type="radio" name="item[origin][isConstructionSite]" value="false" checked> No<br>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">RequiresInsideDelivery:</label>
                                    <div class="col-md-8">
                                        <input type="radio" name="item[origin][requiresInsideDelivery]" value="true"> Yes
                                        <input type="radio" name="item[origin][requiresInsideDelivery]" value="false" checked> No<br>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">IsTradeShow:</label>
                                    <div class="col-md-8">
                                        <input type="radio" name="item[origin][isTradeShow]" value="true"> Yes
                                        <input type="radio" name="item[origin][isTradeShow]" value="false" checked> No<br>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">IsResidential:</label>
                                    <div class="col-md-8">
                                        <input type="radio" name="item[origin][isResidential]" value="true"> Yes
                                        <input type="radio" name="item[origin][isResidential]" value="false" checked> No<br>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">RequiresLiftgate:</label>
                                    <div class="col-md-8">
                                        <input type="radio" name="item[origin][requiresLiftgate]" value="true"> Yes
                                        <input type="radio" name="item[origin][requiresLiftgate]" value="false" checked> No<br>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">HasAppointment:</label>
                                    <div class="col-md-8">
                                        <input type="radio" name="item[origin][hasAppointment]" value="true"> Yes
                                        <input type="radio" name="item[origin][hasAppointment]" value="false" checked> No<br>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">IsLimitedAccess:</label>
                                    <div class="col-md-8">
                                        <input type="radio" name="item[origin][isLimitedAccess]" value="true"> Yes
                                        <input type="radio" name="item[origin][isLimitedAccess]" value="false" checked> No<br>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="destination col-sm-6" id="destination">
                            <fieldset>
                                <legend>ShipTo:</legend>
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label>streetAddress:</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input name="item[destination][streetAddress]" type="text" class="input"></input>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">alternateStreetAddress:</label>
                                    <div class="col-md-8">
                                        <input name="item[destination][alternateStreetAddress]" type="text" class="input"></input>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">majorMunicipality:</label>
                                    <div class="col-md-8">
                                        <input name="item[destination][majorMunicipality]" type="text" class="input"></input>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">postalCode:</label>
                                    <div class="col-md-8">
                                        <input name="item[destination][postalCode]" type="text" class="input"></input>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">stateProvince:</label>
                                    <div class="col-md-8">
                                        <input name="item[destination][stateProvince]" type="text" class="input"></input>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">country:</label>
                                    <div class="col-md-8">
                                        <input name="item[destination][country]" type="text" class="input"></input>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">AddressType:</label>
                                    <div class="col-md-8">
                                        <select name="item[destination][AddressType]" style="width: 100%;">
                                            <option value="Residence">Residence</option>
                                            <option value="BusinessWithLoadingDockOrForklift">Business (with loading dock or forklift)</option>
                                            <option value="BusinessWithoutLoadingDockOrForklift">Business (without loading dock or forklift)</option>
                                            <option value="Port">Port</option>
                                            <option value="ConstructionSite">ConstructionSite</option>
                                            <option value="TradeShowOrConvention">Trade Show / Convention Center</option>
                                            <option value="StorageFacility">Storage Facility</option>
                                            <option value="MilitaryBase">Military Base</option>
                                            <option value="StorageFacility">Storage Facility</option>
                                            <option value="Airport">Airport</option>
                                            <option value="OtherSecuredLocation">Other Secured or Limited Access Location</option>
                                        </select>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend>Contact:</legend>
                                <div class="form-group row">
                                    <label class="col-md-4">name:</label>
                                    <div class="col-md-8">
                                        <input name="item[destination][name]" type="text" class="input"></input>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">companyName:</label>
                                    <div class="col-md-8">
                                        <input name="item[destination][companyName]" type="text" class="input"></input>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">phoneNumber:</label>
                                    <div class="col-md-8">
                                        <input name="item[destination][phoneNumber]" type="tel" class="input"></input>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend>UShip Attribute:</legend>
                                <div class="form-group row">
                                    <label class="col-md-4">Inside:</label>
                                    <div class="col-md-8">
                                        <input type="radio" name="item[destination][inside]" value="true"> Yes
                                        <input type="radio" name="item[destination][inside]" value="false" checked> No<br>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">LiftgateRequired:</label>
                                    <div class="col-md-8">
                                        <input type="radio" name="item[destination][liftgateRequired]" value="true"> Yes
                                        <input type="radio" name="item[destination][liftgateRequired]" value="false" checked> No<br>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">callBeforeArrival:</label>
                                    <div class="col-md-8">
                                        <input type="radio" name="item[destination][callBeforeArrival]" value="true" checked> Yes
                                        <input type="radio" name="item[destination][callBeforeArrival]" value="false"> No<br>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">appointmentRequired:</label>
                                    <div class="col-md-8">
                                        <input type="radio" name="item[destination][appointmentRequired]" value="true" checked> Yes
                                        <input type="radio" name="item[destination][appointmentRequired]" value="false"> No<br>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend>Freightquote Attribute:</legend>
                                <div class="form-group row">
                                    <label class="col-md-4">HasLoadingDock:</label>
                                    <div class="col-md-8">
                                        <input type="radio" name="item[destination][hasLoadingDock]" value="true"> Yes
                                        <input type="radio" name="item[destination][hasLoadingDock]" value="false" checked> No<br>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">IsConstructionSite:</label>
                                    <div class="col-md-8">
                                        <input type="radio" name="item[destination][isConstructionSite]" value="true"> Yes
                                        <input type="radio" name="item[destination][isConstructionSite]" value="false" checked> No<br>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">RequiresInsideDelivery:</label>
                                    <div class="col-md-8">
                                        <input type="radio" name="item[destination][requiresInsideDelivery]" value="true"> Yes
                                        <input type="radio" name="item[destination][requiresInsideDelivery]" value="false" checked> No<br>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">IsTradeShow:</label>
                                    <div class="col-md-8">
                                        <input type="radio" name="item[destination][isTradeShow]" value="true"> Yes
                                        <input type="radio" name="item[destination][isTradeShow]" value="false" checked> No<br>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">IsResidential:</label>
                                    <div class="col-md-8">
                                        <input type="radio" name="item[destination][isResidential]" value="true"> Yes
                                        <input type="radio" name="item[destination][isResidential]" value="false" checked> No<br>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">RequiresLiftgate:</label>
                                    <div class="col-md-8">
                                        <input type="radio" name="item[destination][requiresLiftgate]" value="true"> Yes
                                        <input type="radio" name="item[destination][requiresLiftgate]" value="false" checked> No<br>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">HasAppointment:</label>
                                    <div class="col-md-8">
                                        <input type="radio" name="item[destination][hasAppointment]" value="true"> Yes
                                        <input type="radio" name="item[destination][hasAppointment]" value="false" checked> No<br>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">IsLimitedAccess:</label>
                                    <div class="col-md-8">
                                        <input type="radio" name="item[destination][isLimitedAccess]" value="true"> Yes
                                        <input type="radio" name="item[destination][isLimitedAccess]" value="false" checked> No<br>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </fieldset>
                <fieldset class="route">
                    <legend class="route-legend">Items:</legend>
                    <div class="firstItem" id="firstItem">
                        <div class="sendItem" id="sendItem">
                            <div class="row">
                                <div class="form-group col-sm-6 no-side-margin">
                                    <label class="col-md-4">Commodity:</label>
                                    <div class="col-md-8">
                                        <select name="items[0][Commodity]" style="width: 100%;">
                                            <option value="NewCommercialGoods">NewCommercialGoods</option>
                                            <option value="CarsLightTrucks">CarsLightTrucks</option>
                                            <option value="UsedCommercialGoods">UsedCommercialGoods</option>
                                            <option value="WineLiquorBeerSpirits">WineLiquorBeerSpirits</option>
                                            <option value="NonPerishableFoodsBeverages">NonPerishableFoodsBeverages</option>
                                            <option value="OtherLessthanTruckloadGoods">OtherLessthanTruckloadGoods</option>
                                            <option value="WoodPaperProducts">WoodPaperProducts</option>
                                            <option value="LiquidsGasesChemicals">LiquidsGasesChemicals</option>
                                            <option value="StoneMetalsMinerals">StoneMetalsMinerals</option>
                                            <option value="CommoditiesDryBulk">CommoditiesDryBulk</option>
                                            <option value="GeneralFreight">GeneralFreight</option>
                                            <option value="MixedFreight">MixedFreight</option>
                                            <option value="Utilities">Utilities</option>
                                            <option value="PharmaceuticalProducts">PharmaceuticalProducts</option>
                                            <option value="Fertilizers">Fertilizers</option>
                                            <option value="PlasticsRubber">PlasticsRubber</option>
                                            <option value="TextilesLeather">TextilesLeather</option>
                                            <option value="MiscellaneousManufacturedProducts">MiscellaneousManufacturedProducts</option>
                                            <option value="OtherBusinessIndustrialGoods">OtherBusinessIndustrialGoods</option>
                                            <option value="PaperProducts">PaperProducts</option>
                                            <option value="LogsandOtherWoodintheRough">LogsandOtherWoodintheRough</option>
                                            <option value="WoodProducts">WoodProducts</option>
                                            <option value="PaperorPaperboardArticles">PaperorPaperboardArticles</option>
                                            <option value="PrintedProducts">PrintedProducts</option>
                                            <option value="LiquidsGases">LiquidsGases</option>
                                            <option value="Chemicals">Chemicals</option>
                                            <option value="CrudePetroleumOil">CrudePetroleumOil</option>
                                            <option value="WaterWell">WaterWell</option>
                                            <option value="GasolineandAviationTurbineFuel">GasolineandAviationTurbineFuel</option>
                                            <option value="FuelOils">FuelOils</option>
                                            <option value="ChemicalProductsandPreparationsnec">ChemicalProductsandPreparationsnec</option>
                                            <option value="BuildingMaterials">BuildingMaterials</option>
                                            <option value="MachineryLargeObjects">MachineryLargeObjects</option>
                                            <option value="ElectronicandOtherElectricalEquipmentandComponentsandOfficeEquipment">ElectronicandOtherElectricalEquipmentandComponentsandOfficeEquipment</option>
                                            <option value="PrecisionInstrumentsandApparatus">PrecisionInstrumentsandApparatus</option>
                                            <option value="CoalorCoke">CoalorCoke</option>
                                            <option value="MonumentalorBuildingStone">MonumentalorBuildingStone</option>
                                            <option value="NaturalSands">NaturalSands</option>
                                            <option value="GravelandCrushedStone">GravelandCrushedStone</option>
                                            <option value="NonMetallicMineralsnec">NonMetallicMineralsnec</option>
                                            <option value="MetallicOresandConcentrates">MetallicOresandConcentrates</option>
                                            <option value="CoalandPetroleumProductsnec">CoalandPetroleumProductsnec</option>
                                            <option value="NonMetallicMineralProducts">NonMetallicMineralProducts</option>
                                            <option value="Metalsheetscoilsrolls">Metalsheetscoilsrolls</option>
                                            <option value="BaseMetalinPrimaryorSemiFinishedFormsandinFinishedBasic">BaseMetalinPrimaryorSemiFinishedFormsandinFinishedBasic</option>
                                            <option value="ArticlesofBaseMetal">ArticlesofBaseMetal</option>
                                            <option value="VehicleParts">VehicleParts</option>
                                            <option value="BoatParts">BoatParts</option>
                                            <option value="RefrigeratedFood">RefrigeratedFood</option>
                                            <option value="MeatFishSeafood">MeatFishSeafood</option>
                                            <option value="CerealGrainsincludingseed">CerealGrainsincludingseed</option>
                                            <option value="AnimalFeedProductsofAnimalOrigin">AnimalFeedProductsofAnimalOrigin</option>
                                            <option value="MilledGrainProductsPreparationsandBakeryProducts">MilledGrainProductsPreparationsandBakeryProducts</option>
                                            <option value="Beverages">Beverages</option>
                                            <option value="AlcoholicBeverages">AlcoholicBeverages</option>
                                            <option value="OtherPreparedFoodstuffsandFatsandOils">OtherPreparedFoodstuffsandFatsandOils</option>
                                            <option value="TobaccoProducts">TobaccoProducts</option>
                                            <option value="OtherFoodAgriculture">OtherFoodAgriculture</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 no-side-margin">
                                    <label class="col-md-4">handlingUnit:</label>
                                    <div class="col-md-8">
                                        <select name="items[0][handlingUnit]" style="width:100%;">
                                            <option value="Boxes">Boxes</option>
                                            <option value="Cartons">Cartons</option>
                                            <option value="Crates">Crates</option>
                                            <option value="Drums">Drums</option>
                                            <option value="Bags">Bags</option>
                                            <option value="Bales">Bales</option>
                                            <option value="Bundles">Bundles</option>
                                            <option value="Cans">Cans</option>
                                            <option value="Carboys">Carboys</option>
                                            <option value="Carpets">Carpets</option>
                                            <option value="Cases">Cases</option>
                                            <option value="Coils">Coils</option>
                                            <option value="Cylinders">Cylinders</option>
                                            <option value="Loose">Loose</option>
                                            <option value="NoPackagingRequired">NoPackagingRequired</option>
                                            <option value="PackagingHelpRequired">PackagingHelpRequired</option>
                                            <option value="Pallets48X40Inches">Pallets48X40Inches</option>
                                            <option value="Pails">Pails</option>
                                            <option value="Reels">Reels</option>
                                            <option value="Rolls">Rolls</option>
                                            <option value="TubesPipes">TubesPipes</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-6 no-side-margin">
                                    <label class="col-md-4">unitCount:</label>
                                    <div class="col-md-8">
                                        <input name="items[0][unitCount]" type="text" class="input" value=1></input>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 no-side-margin">
                                    <label class="col-md-4">Length:</label>
                                    <div class="col-md-8">
                                        <input name="items[0][lengthInMeters]" type="text" class="input"></input>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-6 no-side-margin">
                                    <label class="col-md-4">Width:</label>
                                    <div class="col-md-8">
                                        <input name="items[0][widthInMeters]" type="text" class="input"></input>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 no-side-margin">
                                    <label class="col-md-4">Height:</label>
                                    <div class="col-md-8">
                                        <input name="items[0][heightInMeters]" type="text" class="input"></input>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-6 no-side-margin">
                                    <label class="col-md-4">LBS:</label>
                                    <div class="col-md-8">
                                        <input name="items[0][lbs]" type="text" class="input"></input>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 no-side-margin">
                                    <label class="col-md-4">freightClass:</label>
                                    <div class="col-md-8">
                                        <input name="items[0][freightClass]" type="text" class="input"></input>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-6 no-side-margin">
                                    <label class="col-md-4">stackable:</label>
                                    <div class="col-md-8">
                                        <input type="radio" name="items[0][stackable]" value="true" checked> Yes
                                        <input type="radio" name="items[0][stackable]" value="false"> No<br>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 no-side-margin">
                                    <label class="col-md-4">hazardous:</label>
                                    <div class="col-md-8">
                                        <input type="radio" name="items[0][hazardous]" value="true"> Yes
                                        <input type="radio" name="items[0][hazardous]" value="false" checked> No<br>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button id="addItem"><i class="glyphicon glyphicon-plus"></i>add new Item</button>
                </fieldset>
                <div class="form-group row">
                    <div class="col-sm-6">
                        <fieldset class="route">
                            <legend class="route-legend">UShip Attribute:</legend>
                            <div class="form-group row">
                                <label class="col-md-5">protectfromFreezing:</label>
                                <div class="col-md-7">
                                    <input type="radio" name="protectfromFreezing" value="true" > Yes
                                    <input type="radio" name="protectfromFreezing" value="false"checked> No<br>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-5">sortandSegregate:</label>
                                <div class="col-md-7">
                                    <input type="radio" name="sortandSegregate" value="true" > Yes
                                    <input type="radio" name="sortandSegregate" value="false" checked> No<br>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-5">blindShipmentCoordination:</label>
                                <div class="col-md-7">
                                    <input type="radio" name="blindShipmentCoordination" value="true" > Yes
                                    <input type="radio" name="blindShipmentCoordination" value="false" checked> No<br>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="col-sm-6">
                        <fieldset class="route">
                            <legend class="route-legend">FedEx Attribute:</legend>
                            <div class="form-group row">
                                <label class="col-md-4">Dropoff Type:</label>
                                <div class="col-md-8">
                                    <select name="item[dropoffType]" style="width: 100%;">
                                        <option value="BUSINESS_SERVICE_CENTER">BUSINESS_SERVICE_CENTER</option>
                                        <option value="DROP_BOX">DROP_BOX</option>
                                        <option value="REGULAR_PICKUP" selected>REGULAR_PICKUP</option>
                                        <option value="REQUEST_COURIER">REQUEST_COURIER</option>
                                        <option value="STATION">STATION</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4">Service Type:</label>
                                <div class="col-md-8">
                                    <select name="item[serviceType]" style="width: 100%;">
                                        <option value="EUROPE_FIRST_INTERNATIONAL_PRIORITY">EUROPE_FIRST_INTERNATIONAL_PRIORITY</option>
                                        <option value="FEDEX_1_DAY_FREIGHT">FEDEX_1_DAY_FREIGHT</option>
                                        <option value="FEDEX_2_DAY">FEDEX_2_DAY</option>
                                        <option value="FEDEX_2_DAY_AM">FEDEX_2_DAY_AM</option>
                                        <option value="FEDEX_2_DAY_FREIGHT">FEDEX_2_DAY_FREIGHT</option>
                                        <option value="FEDEX_3_DAY_FREIGHT">FEDEX_3_DAY_FREIGHT</option>
                                        <option value="FEDEX_DISTANCE_DEFERRED">FEDEX_DISTANCE_DEFERRED</option>
                                        <option value="FEDEX_EXPRESS_SAVER">FEDEX_EXPRESS_SAVER</option>
                                        <option value="FEDEX_FIRST_FREIGHT">FEDEX_FIRST_FREIGHT</option>
                                        <option value="FEDEX_FREIGHT_ECONOMY">FEDEX_FREIGHT_ECONOMY</option>
                                        <option value="FEDEX_FREIGHT_PRIORITY">FEDEX_FREIGHT_PRIORITY</option>
                                        <option value="FEDEX_GROUND">FEDEX_GROUND</option>
                                        <option value="FEDEX_NEXT_DAY_AFTERNOON">FEDEX_NEXT_DAY_AFTERNOON</option>
                                        <option value="FEDEX_NEXT_DAY_EARLY_MORNING">FEDEX_NEXT_DAY_EARLY_MORNING</option>
                                        <option value="FEDEX_NEXT_DAY_END_OF_DAY">FEDEX_NEXT_DAY_END_OF_DAY</option>
                                        <option value="FEDEX_NEXT_DAY_FREIGHT">FEDEX_NEXT_DAY_FREIGHT</option>
                                        <option value="FEDEX_NEXT_DAY_MID_MORNING">FEDEX_NEXT_DAY_MID_MORNING</option>
                                        <option value="FIRST_OVERNIGHT">FIRST_OVERNIGHT</option>
                                        <option value="GROUND_HOME_DELIVERY">GROUND_HOME_DELIVERY</option>
                                        <option value="INTERNATIONAL_ECONOMY">INTERNATIONAL_ECONOMY</option>
                                        <option value="INTERNATIONAL_ECONOMY_FREIGHT">INTERNATIONAL_ECONOMY_FREIGHT</option>
                                        <option value="INTERNATIONAL_FIRST">INTERNATIONAL_FIRST</option>
                                        <option value="INTERNATIONAL_PRIORITY" selected>INTERNATIONAL_PRIORITY</option>
                                        <option value="INTERNATIONAL_PRIORITY_FREIGHT">INTERNATIONAL_PRIORITY_FREIGHT</option>
                                        <option value="PRIORITY_OVERNIGHT">PRIORITY_OVERNIGHT</option>
                                        <option value="SAME_DAY">SAME_DAY</option>
                                        <option value="SAME_DAY_CITY">SAME_DAY_CITY</option>
                                        <option value="SMART_POST">SMART_POST</option>
                                        <option value="STANDARD_OVERNIGHT">STANDARD_OVERNIGHT</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4">Packaging Type:</label>
                                <div class="col-md-8">
                                    <select name="item[packagingType]" style="width: 100%;">
                                        <option value="FEDEX_10KG_BOX">FEDEX_10KG_BOX</option>
                                        <option value="FEDEX_25KG_BOX">FEDEX_25KG_BOX</option>
                                        <option value="FEDEX_BOX">FEDEX_BOX</option>
                                        <option value="FEDEX_ENVELOPE">FEDEX_ENVELOPE</option>
                                        <option value="FEDEX_EXTRA_LARGE_BOX">FEDEX_EXTRA_LARGE_BOX</option>
                                        <option value="FEDEX_LARGE_BOX">FEDEX_LARGE_BOX</option>
                                        <option value="FEDEX_MEDIUM_BOX">FEDEX_MEDIUM_BOX</option>
                                        <option value="FEDEX_PAK">FEDEX_PAK</option>
                                        <option value="FEDEX_SMALL_BOX">FEDEX_SMALL_BOX</option>
                                        <option value="FEDEX_TUBE">FEDEX_TUBE</option>
                                        <option value="YOUR_PACKAGING" selected>YOUR_PACKAGING</option>
                                    </select>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                    <input type="submit" value="Send" id="submit" class="col-sm-3 col-md-2 col-lg-2 col-xs-4 pull-right" style="margin-top: 10px;">
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
<script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script>
    jQuery(document).ready(function($) {
        var i=0;
        $('#addItem').click(function(e) {
            i++;
            e.preventDefault();
            var newdiv = $("#firstItem div.sendItem").eq(0).clone();
            console.log(newdiv);
            newdiv.find('input').each(function(){
                this.name = this.name.replace('[0]', '['+i+']');
            });
            newdiv.find('select').each(function(){
                this.name = this.name.replace('[0]', '['+i+']');
            })
            $('#firstItem').append(newdiv);
        });
    });
</script>
