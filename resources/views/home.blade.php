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
                <fieldset class="route">
                    <legend class="route-legend">Route:</legend>
                    <div class="itemdiv" id="itemdiv">
                        <div class="first" id="first">
                            <fieldset>
                                <legend>Address:</legend>
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
                                        <select name="item[origin][AddressType]">
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
                                <legend>Attribute:</legend>
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
                                        <input type="radio" name="item[origin][callBeforeArrival]" value="true"> Yes
                                        <input type="radio" name="item[origin][callBeforeArrival]" value="false" checked> No<br>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">appointmentRequired:</label>
                                    <div class="col-md-8">
                                        <input type="radio" name="item[origin][appointmentRequired]" value="true"> Yes
                                        <input type="radio" name="item[origin][appointmentRequired]" value="false" checked> No<br>
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
                        </div>
                        <div class="destination" id="destination ">
                            <fieldset>
                                <legend>Address:</legend>
                                <div class="form-group row">
                                    <label class="col-md-4">postalCode:</label>
                                    <div class="col-md-8">
                                        <input name="item[destination][postalCode]" type="text" class="input"></input>
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
                                        <select name="item[destination][AddressType]">
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
                                <legend>Attribute:</legend>
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
                                        <input type="radio" name="item[destination][callBeforeArrival]" value="true"> Yes
                                        <input type="radio" name="item[destination][callBeforeArrival]" value="false" checked> No<br>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">appointmentRequired:</label>
                                    <div class="col-md-8">
                                        <input type="radio" name="item[destination][appointmentRequired]" value="true"> Yes
                                        <input type="radio" name="item[destination][appointmentRequired]" value="false" checked> No<br>
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
                        </div>
                    </div>
                </fieldset>
                <fieldset class="route">
                    <legend class="route-legend">Items:</legend>
                        <div class="firstItem" id="firstItem">
                            <div class="sendItem" id="sendItem">
                                <div class="form-group row">
                                    <label class="col-md-4">Commodity:</label>
                                    <div class="col-md-8">
                                        <select name="items[0][Commodity]">
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
                                <div class="form-group row">
                                    <label class="col-md-4">unitCount:</label>
                                    <div class="col-md-8">
                                        <input name="items[0][unitCount]" type="text" class="input" value=1></input>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">packaging:</label>
                                    <div class="col-md-8">
                                        <select name="items[0][packaging]">
                                            <option value="Pallets">Pallets</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">lengthInMeters:</label>
                                    <div class="col-md-8">
                                        <input name="items[0][lengthInMeters]" type="text" class="input"></input>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">heightInMeters:</label>
                                    <div class="col-md-8">
                                        <input name="items[0][heightInMeters]" type="text" class="input"></input>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">LBS:</label>
                                    <div class="col-md-8">
                                        <input name="items[0][lbs]" type="text" class="input"></input>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">freightClass:</label>
                                    <div class="col-md-8">
                                        <input name="items[0][freightClass]" type="text" class="input"></input>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">stackable:</label>
                                    <div class="col-md-8">
                                        <input type="radio" name="items[0][stackable]" value="true"> Yes
                                        <input type="radio" name="items[0][stackable]" value="false" checked> No<br>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">hazardous:</label>
                                    <div class="col-md-8">
                                        <input type="radio" name="items[0][hazardous]" value="true"> Yes
                                        <input type="radio" name="items[0][hazardous]" value="false" checked> No<br>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">handlingUnit:</label>
                                    <div class="col-md-8">
                                        <select name="items[0][handlingUnit]">
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
                        </div>
                    <button id="addItem"><i class="glyphicon glyphicon-plus"></i>add new Item</button>
                </fieldset>
                <fieldset class="route">
                    <legend class="route-legend">Attribute</legend>
                    <div class="form-group row">
                        <label class="col-md-4">protectfromFreezing:</label>
                        <div class="col-md-8">
                            <input type="radio" name="protectfromFreezing" value="true" > Yes
                            <input type="radio" name="protectfromFreezing" value="false"checked> No<br>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4">sortandSegregate:</label>
                        <div class="col-md-8">
                            <input type="radio" name="sortandSegregate" value="true" > Yes
                            <input type="radio" name="sortandSegregate" value="false" checked> No<br>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4">blindShipmentCoordination:</label>
                        <div class="col-md-8">
                            <input type="radio" name="blindShipmentCoordination" value="true" > Yes
                            <input type="radio" name="blindShipmentCoordination" value="false" checked> No<br>
                        </div>
                    </div>
                </fieldset>
                <fieldset class="route">
                    <legend class="route-legend">ShippingType</legend>
                    <div>
                        <input type="radio" name="thirdParty" value="uship" checked> UShip<br>
                        <input type="radio" name="thirdParty" value="UPS"> UPS<br>
                        <input type="radio" name="thirdParty" value="FedEx"> FedEx
                    </div>
                </fieldset>
                <input type="submit" value="Send" id="submit">
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
