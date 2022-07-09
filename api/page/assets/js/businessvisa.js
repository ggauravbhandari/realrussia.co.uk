/// <reference path="http://ajax.aspnetcdn.com/ajax/4.0/1/MicrosoftAjax.js" />
/// <reference path="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.7.1.js" />
/// <reference path="http://visas.realrussia.local/visas/belarusia/scripts/infrastructure.data.js" />
/// <reference path="http://visas.realrussia.local/Russian/scripts/visas.russian.js" />
/// <reference path="http://visas.realrussia.local/Russian/scripts/visas.russian.prices.js" />
/// <reference path="http://visas.realrussia.local/Russian/scripts/Visas.Russian.js" />
/// <reference path="../incl/scripts/linq-vsdoc.js.js" />
/// <reference path="http://visas.realrussia.local/scripts/realrussia.js" />
/// <reference path="http://visas.realrussia.local/Russian/Areas/Rules/Scripts/Visas.Russian.Rules.js" />
/// <reference path="https://visas.realrussia.local/inc/scripts/Visas.Russian.UI.js" />


(function () {

    function ResidenceSectionComponent(options) {
        var citizenship$ = options.elements.citizenship$;

        var section$ = options.elements.ukResidenceSection$ || $("#UKResidence-section");
        var question$ = options.elements.ukResidenceSectionQuestion$ || $("#UKResidence-section-question-10-14-group");
        var visaFreeQuestion$ = options.elements.ukResidenceSectionQuestionVisaFree$ || $("#UKResidence-section-question-visa-free");
        var additionalInfo$ = options.elements.additionalInfo$ || $("#UKResidence-section-additional-info");
        var hasUKResidence$ = options.elements.hasUKResidence$ || $("#hasUKResidence");
        var answerYes$ = options.elements.hasUKResidenceYes$ || $("#hasUKResidence-yes") || hasUKResidence$.first();

        var ruleChecker = options.ruleChecker;

        var noSamedayText = question$.length
            ? question$.text()
            : "Do you have UK residence permit or long term UK work/student visa for a term exceeding {days} days or proof of UK address for the last {days} days?";

        var noVisaText = visaFreeQuestion$.length
            ? visaFreeQuestion$.text()
            : "Do you have Long Term UK Leave To Remain or a UK residence permit?";


        function updateInformationBlock() {
            additionalInfo$.hide();
            section$.hide();

            answerYes$.prop("checked", true);

            var country = citizenship$.val();
            if (!country)
                return;

            var texts = "";

            ruleChecker.GetCitizenshipGroups(country,
                function (groups) {

                    if (groups && groups.length > 0) {
                        texts = groups.reduce(function (acc, x) {
                            if (x.Message)
                                acc += x.Message;

                            return acc;
                        }, "");


                        texts = texts.replace(/\{country\}/g, country);

                        var ids = groups.map(function (x) {
                            return x.Id;
                        });

                        if (ruleChecker.IsCountryInGroup("BusinessVisaFree", ids)) {
                            texts = "Citizens of " + country + " do not require a business visa to visit the Russian Federation";
                            if (ruleChecker.IsCountryInGroup(Visas.Russian.Rules.CitizenshipGroupId.VisaFreeFor30Days, ids)) {
                                texts += " for up to 30 days";
                            } else if (ruleChecker.IsCountryInGroup(Visas.Russian.Rules.CitizenshipGroupId.VisaFreeFor30Days, ids)) {
                                texts += " for up to 30 days";
                            } else if (ruleChecker.IsCountryInGroup(Visas.Russian.Rules.CitizenshipGroupId.VisaFreeFor60Days, ids)) {
                                texts += " for up to 60 days";
                            } else if (ruleChecker.IsCountryInGroup(Visas.Russian.Rules.CitizenshipGroupId.VisaFreeFor90Days, ids)) {
                                texts += " for up to 90 days";
                            }
                            texts +=
                                ". The maximum period of visa-free stay in the course of multiple visits cannot exceed 90 days in any 180-day period starting from the day of the first entry.";

                            if ("Armenia,Azerbaijan,Kazakhstan,Kyrgyzstan,Moldova,Tajikistan,Ukraine,Uzbekistan".indexOf(country) >= 0) {
                                texts = "Citizens of " + country + " do not require a visa for travel to the Russian Federation. Please note though that the maximum period of stay in the course of multiple visits cannot exceed 90 days in any 180-day period starting from the day of the first entry.";
                            } else if ("Argentina,Cuba,Chile,Columbia,Fiji,Guatemala,Nicaragua,Peru,Venezuela,Israel,Macedonia".indexOf(country) >= 0) {
                                texts = "Citizens of " + country + " do not require a visa to visit the Russian Federation for up to 90 days in any 180-day period starting from the day of the first entry unless the purpose of their visit is work, study or permanent residency in Russia.";
                                if ("Israel,Macedonia".indexOf(country) >= 0) {
                                    texts += " In case of a visa-free entry, it is necessary to present the original visa support documents (invitation) to the immigration authorities at passport control on arrival.";
                                }
                            } else if ("Macau,Montenegro,Mongolia,Thailand".indexOf(country) >= 0) {
                                texts = "Citizens of " + country + " do not require a visa to visit the Russian Federation for up to 30 days unless the purpose of their visit is work, study or permanent residency in Russia. Please note that the maximum period of a visa-free stay in the course of multiple visits cannot exceed 90 days in any 180-day period starting from the day of the first entry.";
                            } else if (country === "Bosnia and Herzegovina") {
                                texts = "Citizens of Bosnia and Herzegovina do not require a visa to visit the Russian Federation for up to 30 days in any 60-day period starting from the day of the first entry unless the purpose of their visit is work, study or permanent residency in Russia. In case of a visa-free entry, it is necessary to present the original visa support documents (invitation) to the immigration authorities at passport control on arrival. Please note that the maximum period of visa-free stay in the course of multiple visits cannot exceed 90 days in any 180-day period starting from the day of the first entry.";
                            } else if (country === "El Salvador") {
                                texts = "Starting from 27 August 2016 citizens of El Salvador do not require a tourist visa to visit the Russian Federation for up to 90 days in any 180-day period starting from the day of the first entry.";
                            } else if (country === "Hong Kong") {
                                texts = "Holders of Hong Kong Special Administrative Region passport do not require a visa to visit the Russian Federation for up to 14 days unless the purpose of their visit is work, study or permanent residency in Russia. Please note that the maximum period of a visa-free stay in the course of multiple visits cannot exceed 90 days in any 180-day period starting from the day of the first entry.";
                            } else if (country === "Venezuela") {
                                texts = "Citizens of Venezuela do not require a visa to visit the Russian Federation for up to 90 days.";
                            } else if (country === "Republic of Korea") {
                                texts = "Citizens of Republic of Korea do not require a visa to visit the Russian Federation for up to 60 days unless the purpose of their visit is work, study or permanent residency in Russia. Please note that the maximum period of a visa-free stay in the course of multiple visits cannot exceed 90 days in any 180-day period starting from the day of the first entry.";
                            } else if (country === "Serbia") {
                                texts = "Citizens of Serbia with biometric passports obtained after April 9th, 2008 do not require a visa to visit the Russian Federation for up to 30 days unless the purpose of their visit is work, study or permanent residency in Russia. Serbian nationalities with temporary and permanent resident permits can stay without time limits. In all other cases visa is required. Visa free regime does not apply for Yugoslavian passports holders. Please note that the maximum period of a visa-free stay for biometric passport holders in the course of multiple visits cannot exceed 90 days in any 180-day period.";
                            }


                            texts +=
                                "\r\nPlease note that of 2014, leaving and re-entering the country in order to \"reset\" the maximum allowed visa-free period is no longer allowed. Overstaying may lead to a three-year entry ban.";
                            if (country !== "Serbia") {
                                texts +=
                                    " We recommend you to always check the current requirements with your airline company as they are subject to change.";
                            }

                            section$.show();
                            question$.html(noVisaText);
                        }

                        if (ruleChecker.IsCountryInGroup("Standard10x14CD", ids)) {
                            var question;
                            if (country === "Australia") {
                                question = noSamedayText.replace(/{days}/g, "180");
                            } else
                                question = noSamedayText.replace(/{days}/g, "90");

                            question$.html(question);
                            section$.show();
                        }

                        if (texts) {
                            additionalInfo$.html(texts);
                            additionalInfo$.show();
                        } else {
                            additionalInfo$.hide();
                        }

                    }

                });
        }

        citizenship$.change(function () {
            updateInformationBlock();
        });

        //init
        visaFreeQuestion$.hide();
        section$.hide();
        additionalInfo$.hide();
        answerYes$.prop("checked", true);

        updateInformationBlock();
    };

    ResidenceSectionComponent.Run = function (options) {
        ResidenceSectionComponent.Current = new ResidenceSectionComponent(options);
    };

    function FieldsSectionComponent(options) {
        EntryTypesManager.Run(options);
        VSDServiceTypesManager.Run(options);
        Visas.Russian.UI.ConsularServiceManager.Run(options);
        Visas.Russian.UI.ApplyDateComponent.Run(options);
    }
    FieldsSectionComponent.Run = function (options) {
        FieldsSectionComponent.Current = new FieldsSectionComponent(options);
    };

    function EntryTypesManager(options) {
        (function FilterBehaviour() {
            var citizenship$ = options.elements.citizenship$;
            var entryType$ = options.elements.entryType$;
            var ruleChecker = options.ruleChecker;

            function update() {

                function enableAll() {
                    var options$ = entryType$.find("option");
                    options$.each(function() {
                        allowOption($(this));
                    });
                }

                var citizenship = citizenship$.val();
                if (!citizenship) {
                    enableAll();
                    return;
                }

                if (update.citizenship === citizenship)
                    return;

                update.citizenship = citizenship;

              
                var options$ = entryType$.find("option");
                ruleChecker.IsCountryInGroup(citizenship, Visas.Russian.Rules.CitizenshipGroupId.TIN).done(function (res) {
                    
                    var option$ = options$.filter("[value=" + Visas.Russian.EntryTypeId.Multi2Years + "]");
                    if (res)
                        allowOption(option$);
                    else
                        denyOption(option$);

                    option$ = options$.filter("[value=" + Visas.Russian.EntryTypeId.Multi3Years + "]");
                    if (res)
                        allowOption(option$);
                    else
                        denyOption(option$);

                    option$ = options$.filter("[value=" + Visas.Russian.EntryTypeId.Multi5Years + "]");
                    if (res)
                        allowOption(option$);
                    else
                        denyOption(option$);
                });
            }

            citizenship$.change(function() {
                update();
            });

            update();
        })();
    }
    EntryTypesManager.Run = function (options) {
        EntryTypesManager.Current = new EntryTypesManager(options);
    };

    function VSDServiceTypesManager(options) {
        (function FilterBehaviour() {
            var citizenship$ = options.elements.citizenship$;
            var entryType$ = options.elements.entryType$;
            var hasUKResidence$ = options.elements.hasUKResidence$;
            var vsdServiceType$ = options.elements.vsdServiceType$;

            var ruleChecker = options.ruleChecker;

            function getVSDServicesForEntryType(entryType) {
                var vsdServicesForEntryTypes =
                    [
                        {
                            EntryType: Visas.Russian.EntryTypeId.Single30,
                            VSDServices: [
                                Visas.Russian.VisaSupportServiceTypeId.x12WorkingDays,
                                Visas.Russian.VisaSupportServiceTypeId.x8WorkingDays,
                                Visas.Russian.VisaSupportServiceTypeId.TIN
                            ]
                        },
                        {
                            EntryType: Visas.Russian.EntryTypeId.Single90,
                            VSDServices: [
                                Visas.Russian.VisaSupportServiceTypeId.x12WorkingDays,
                                Visas.Russian.VisaSupportServiceTypeId.x8WorkingDays,
                                Visas.Russian.VisaSupportServiceTypeId.TIN
                            ]
                        },
                        {
                            EntryType: Visas.Russian.EntryTypeId.Double30,
                            VSDServices: [
                                Visas.Russian.VisaSupportServiceTypeId.x12WorkingDays,
                                Visas.Russian.VisaSupportServiceTypeId.x8WorkingDays,
                                Visas.Russian.VisaSupportServiceTypeId.TIN
                            ]
                        },
                        {
                            EntryType: Visas.Russian.EntryTypeId.Double90,
                            VSDServices: [
                                Visas.Russian.VisaSupportServiceTypeId.x12WorkingDays,
                                Visas.Russian.VisaSupportServiceTypeId.x8WorkingDays,
                                Visas.Russian.VisaSupportServiceTypeId.TIN
                            ]
                        },
                        {
                            EntryType: Visas.Russian.EntryTypeId.Multiple06,
                            VSDServices: [
                                Visas.Russian.VisaSupportServiceTypeId.x18WorkingDays,
                                Visas.Russian.VisaSupportServiceTypeId.x14WorkingDays,
                                Visas.Russian.VisaSupportServiceTypeId.TIN
                            ]
                        },
                        {
                            EntryType: Visas.Russian.EntryTypeId.Multiple12,
                            VSDServices: [
                                Visas.Russian.VisaSupportServiceTypeId.x18WorkingDays,
                                Visas.Russian.VisaSupportServiceTypeId.x14WorkingDays,
                                Visas.Russian.VisaSupportServiceTypeId.TIN
                            ]
                        },
                        {
                            EntryType: Visas.Russian.EntryTypeId.Multi2Years,
                            VSDServices: [
                                Visas.Russian.VisaSupportServiceTypeId.TIN
                            ]
                        },
                        {
                            EntryType: Visas.Russian.EntryTypeId.Multi3Years,
                            VSDServices: [
                                Visas.Russian.VisaSupportServiceTypeId.TIN
                            ]
                        },
                        {
                            EntryType: Visas.Russian.EntryTypeId.Multi5Years,
                            VSDServices: [
                                Visas.Russian.VisaSupportServiceTypeId.TIN
                            ]
                        }
                    ];

                for (var i = 0; i < vsdServicesForEntryTypes.length; i++) {
                    var vsdServicesForEntryTypesSetting = vsdServicesForEntryTypes[i];
                    if (vsdServicesForEntryTypesSetting.EntryType === entryType)
                        return vsdServicesForEntryTypesSetting.VSDServices.clone();
                }

                return [];
            }

            function getCurrentConditionRules() {
                var hasUKResidence;
                if (hasUKResidence$.length) {
                    hasUKResidence = hasUKResidence$.filter(":checked").val() === "Yes";
                }

                var conditionRules = [Visas.Russian.Rules.Condition.CountryResidence];
                if (hasUKResidence) {
                    conditionRules.push(Visas.Russian.Rules.Condition.UKResidence);
                }

                return conditionRules;
            }

            function updateVSDServicesByEntryType() {
                function allowAll() {
                    var options$ = vsdServiceType$.find("option");
                    options$.each(function () {
                        allowOption($(this));
                    });
                }

                var entryType = entryType$.val();
                if (!entryType) {
                    allowAll();
                    return;
                }

                var entryTypeId = parseInt(entryType);

                //cache invoked params
                if (updateVSDServices.entryTypeId === entryTypeId)
                    return;

                updateVSDServices.entryTypeId = entryTypeId;

                var vsdServicesForEntryType = getVSDServicesForEntryType(entryTypeId);

                var options$ = vsdServiceType$.find("option").not("[value=''], [value='0']");

                options$.each(function () {
                    var option$ = $(this);
                    var optionEntryTypeId = parseInt(option$.attr("value"));
                    var isAvailable = vsdServicesForEntryType.indexOf(optionEntryTypeId) >= 0;
                    if (isAvailable)
                        allowOption(option$);
                    else
                        denyOption(option$);
                });

            }

            function updateVSDServices() {
                function allowAll() {
                    var options$ = vsdServiceType$.find("option");
                    options$.each(function () {
                        allowOption($(this));
                    });
                }

                function getEntryTypeId() {
                    var entryType = entryType$.val();
                    if (entryType)
                        return parseInt(entryType);
                    return;
                }

                function getVSDServiceTypeId() {
                    var vsdServiceType = vsdServiceType$.val();
                    if (vsdServiceType)
                        return parseInt(vsdServiceType);
                    return;
                }

                var citizenship = citizenship$.val();
                var entryTypeId = getEntryTypeId();

                if (!citizenship || !entryTypeId) {
                    allowAll();
                    return;
                }

                
                var conditionRules = getCurrentConditionRules();

                //cache invoked params
                if (updateVSDServices.citizenship === citizenship && updateVSDServices.entryTypeId === entryTypeId && arraysEqual(updateVSDServices.conditionRules, conditionRules))
                    return;
                updateVSDServices.citizenship = citizenship;
                updateVSDServices.entryTypeId = entryTypeId;
                updateVSDServices.conditionRules = conditionRules;

                var vsdServicesForEntryType = getVSDServicesForEntryType(entryTypeId);

                var currentVSDServiceTypeId = getVSDServiceTypeId();

                var options$ = vsdServiceType$.find("option").not("[value=''], [value='0']");
                options$.each(function () {
                    var option$ = $(this);
                    var optionVSDServiceTypeId = parseInt(option$.attr("value"));
                    var isAvailableFoEntryType = vsdServicesForEntryType.indexOf(optionVSDServiceTypeId) >= 0;
                    if (isAvailableFoEntryType) {
                        ruleChecker.IsServiceAvailable(
                            citizenship,
                            Visas.Russian.VisaTypeId.Business,
                            entryTypeId,
                            optionVSDServiceTypeId,
                            null,
                            conditionRules,
                            true, function (res, context) {
                                var currentCitizenship = citizenship$.val();
                                var currentEntryTypeId = getEntryTypeId();
                                var currentConditionRules = getCurrentConditionRules();
                                if (currentCitizenship !== citizenship)
                                    return;
                                if (currentEntryTypeId !== entryTypeId)
                                    return;
                                if (!arraysEqual(currentConditionRules, conditionRules))
                                    return;

                                if (!res) {
                                    if (currentVSDServiceTypeId === context.VSDServiceTypeId) {
                                        alert("Current selected invitation service is not available for your citizenship and has been reset. Please check and select another invitation service");
                                        vsdServiceType$.val("").trigger("change");
                                    }

                                }
                                if (res)
                                    allowOption(option$);
                                else
                                    denyOption(option$);

                            });
                    }
                    else
                        denyOption(option$);
                });
            }

            citizenship$
                .add(entryType$)
                .add(hasUKResidence$).change(function() {
                    updateVSDServices();
                });

            updateVSDServices();
            
        })();
    }
    VSDServiceTypesManager.Run = function (options) {
        VSDServiceTypesManager.Current = new VSDServiceTypesManager(options);
    };

    function CitizenshipManager(options) {
        var citizenship$ = options.elements.citizenship$;

        function update() {
            function showValidationMessage() {
                var parent$ = citizenship$.parent();
                var errorClass = "input-validation-error";
                var error$ = parent$.find("span." + errorClass);
                if (error$.length === 0) {
                    error$ = $("<span class=\"" + errorClass + "\">Please select citizenship</span>");
                    error$.appendTo(parent$);
                }

                error$.show();
            }

            function hideValidationMessage() {
                var errorClass = "input-validation-error";
                var parent$ = citizenship$.parent();
                var error$ = parent$.find("span." + errorClass);
                error$.hide();
            }

            var citizenship = citizenship$.val();
            if (update.citizenship === citizenship)
                return;

            update.citizenship = citizenship;

            if (citizenship) {
                hideValidationMessage();
            }
            else {
                showValidationMessage();
            }
        }

        citizenship$.change(function() {
            update();
        });

        update();
    }
    CitizenshipManager.Run = function (options) {
        CitizenshipManager.Current = new CitizenshipManager(options);
    };

    function DocumentsRequirementsComponent(options) {
        var citizenship$ = options.elements.citizenship$;
        var purposeOfVisit$ = options.elements.purposeOfVisit$;
        var typeVSD$ = options.elements.typeVSD$;

        function showRussianRequirements(country, purpose, vsd) {
            var countryLabel = "<h5>Documents required for passport holders of " + country + ":</h5>";
            var nationalityRequirementsDiv = document.getElementById("nationalityRequirements");
            var forWhat = "bisvisa";
            var visatype = "business";
            var sdm = "SE";
            var age = 100;
            var request = getRequest();
            var url = "//" + visasHost + "/inc/showRequirements.asp" + "?country=" + country + "&forWhat=" + forWhat + "&visatype=" + visatype + "&sdm=" + sdm + "&age=" + age + "&purpose=" + purpose + "&typeVSD=" + vsd;
            request.open("GET", url, true);
            request.onreadystatechange = function () {
                if (request.readyState === 4) {
                    if (request.status === 200) {
                        nationalityRequirementsDiv.innerHTML = countryLabel + request.responseText;
                    }
                };
            }
            request.send("0");
        }

        function update() {
            var citizenship = citizenship$.val();
            var purpose = purposeOfVisit$.val();
            var typeVSD = typeVSD$.find(":selected").text();
            showRussianRequirements(citizenship, purpose, typeVSD);
        }

        citizenship$
            .add(purposeOfVisit$)
            .add(typeVSD$)
            .change(function() {
                update();
            });

        update();
    }
    DocumentsRequirementsComponent.Run = function (options) {
        DocumentsRequirementsComponent.Current = new DocumentsRequirementsComponent(options);
    };

    function PurposesOfVisitManager(options) {
        var typeVSD$ = options.elements.typeVSD$;
        var purposeOfVisit$ = options.elements.purposeOfVisit$;
        var selpurpose = purposeOfVisit$[0];

        function update() {
            selpurpose.length = 0;
            var typeVSD = typeVSD$.val();
            if (typeVSD === "Electronic invitation") {
                selpurpose.options[selpurpose.length] = new Option("Business");
            } else {
                selpurpose.options[selpurpose.length] = new Option("Business");
                selpurpose.options[selpurpose.length] = new Option("Charity");
                selpurpose.options[selpurpose.length] = new Option("Commercial");
                selpurpose.options[selpurpose.length] = new Option("Cultural");
                selpurpose.options[selpurpose.length] = new Option("Family member");
                selpurpose.options[selpurpose.length] = new Option("Scientific");
                selpurpose.options[selpurpose.length] = new Option("Technical Support");
                selpurpose.options[selpurpose.length] = new Option("Youth Work");
            }
        }

        typeVSD$.change(function() {
            update();
        });

        update();
    }
    PurposesOfVisitManager.Run = function (options) {
        PurposesOfVisitManager.Current = new PurposesOfVisitManager(options);
    };


    function PageComponent(options) {
        FieldsSectionComponent.Run(options);
        ResidenceSectionComponent.Run(options);
        Visas.Russian.UI.ServicesSectionComponent.Run(options);        
        CitizenshipManager.Run(options);
        PurposesOfVisitManager.Run(options);
        DocumentsRequirementsComponent.Run(options);
    }
    PageComponent.Run = function (options) {
        PageComponent.Current = new PageComponent(options);
    };


    var visasHost = 'visas.realrussia.co.uk'; //RRHelper.GetVisasHostname();
    var priceServiceProxy = new Visas.Russian.Prices.PriceServiceProxy("//" + visasHost + "/Russian/");
    var dateCalculatorProxy = new Visas.Russian.DateCalculating.DateCalculatorProxy("//" + visasHost + "/Russian/", { jsonp: true });
    var ruleChecker = new Visas.Russian.Rules.RuleChecker({
        hostUrl: "//" + visasHost
    });

    $(document).ready(function () {
        if (!Modernizr.inputtypes.date) {
            $("input[type='date']").datepicker({
                dateFormat: "yy-mm-dd"
            }).keypress(function (e) {
                e.preventDefault();
            });
        }

        var citizenship$ = $("#citizenship, #nationalitySelect, #nationalitySelect2")
            .replicateChanges();

        var elements = {
            citizenship$: citizenship$,
            hasUKResidence$: $("[name=hasUKResidence]"),
            tourDate$: $("#tourDate"),
            consulateCity$: $("#consulateCity"),
            consularServiceType$: $("#consularServiceType"),
            entryType$: $("#entryType"),
            vsdServiceType$: $("#VSDServiceType"),
            purposeOfVisit$: $("#purposeOfVisitSelect"),
            typeVSD$: $("#typeVSD")
        };

        PageComponent.Run({
            elements: elements,
            ruleChecker: ruleChecker,
            dateCalculatorProxy: dateCalculatorProxy,
            priceServiceProxy: priceServiceProxy,
            visaTypeId: Visas.Russian.VisaTypeId.Business,
            rules: {
                servicesBCAreAvailableOnlyForUK: true,
                serviceCAvailableOnlyInLondon: true
            }
        });

        Visas.Russian.Pages.BusinessInformation.OrderTablesUpdater.Run({
            $citizenship: citizenship$,
            $answer: $("[name=hasUKResidence]"),
            dateCalculatorProxy: dateCalculatorProxy,
            priceServiceProxy: priceServiceProxy,
            $tables: $(".price-table"),
            ruleChecker: ruleChecker,
            elements: {
                detailedServiceSection$: ".DnnModule-7440, .DnnModule-8163",
                tinSections$: ".detailed-service-section-exclusive",
                collapsePanelLinks$: ".panel-title a"
            }
        });
    });

    function getPrice(prices, visaServiceTypeId, entryTypeId, visaSupportServiceId, consulateServiceTypeId) {
        if (!prices)
            return null;

        for (var i = 0; i < prices.length; i++) {
            var record = prices[i];
            if (record.EntryTypeId === entryTypeId
                && record.ServiceTypeId === visaServiceTypeId
                && record.ConsulateServiceTypeId === consulateServiceTypeId
                && record.VisaSupportServiceTypeId === visaSupportServiceId) {
                return record.Total;
            }
        }

        return null;
    }

    function getLinkContext(a$) {
        var consularServiceTypeId, parent$;
        var consularServiceCode = a$.data("consular-service");        
        if (!consularServiceCode) {
            parent$ = a$.parents("[data-consular-service]");
            consularServiceCode = parent$.data("consular-service");
            a$.data("consular-service", consularServiceCode);
        }
        if (consularServiceCode)
            consularServiceTypeId = parseConsulateServiceTypeId(consularServiceCode);

        var vsdServiceTypeId;
        var vsdServiceCode = a$.data("vsd-service");
        if (!vsdServiceCode) {
            parent$ = a$.parents("[data-vsd-service]");
            vsdServiceCode = parent$.data("vsd-service");
            if (vsdServiceCode || vsdServiceCode == "0")
                vsdServiceCode += "";

            a$.data("vsd-service", vsdServiceCode);
        }
        if (vsdServiceCode || vsdServiceCode == "0")
            vsdServiceTypeId = parseVSDServiceTypeId(vsdServiceCode);

        var visaServiceTypeId = null;
        var visaServiceCode = a$.data("visa-service");
        if (!visaServiceCode) {
            parent$ = a$.parents("[data-visa-service]");
            visaServiceCode = parent$.data("visa-service");
            a$.data("visa-service", visaServiceCode);
        }
        if (visaServiceCode)
            visaServiceTypeId = parseVisaServiceTypeId(visaServiceCode);

        var entryTypeId;
        var entryType = a$.data("entry");
        if (!entryType) {
            parent$ = a$.parents("[data-entry]");
            entryType = parent$.data("entry");
            a$.data("entryType", entryType);
        }
        if (entryType)
            entryTypeId = parseEntryTypeId(entryType);

        return {
            consularServiceTypeId: consularServiceTypeId,
            vsdServiceTypeId: vsdServiceTypeId,
            visaServiceTypeId: visaServiceTypeId,
            entryTypeId: entryTypeId
        };

    }

    
    function parseEntryTypeId(val) {
        

        switch (val) {
            case "SE30":
                return Visas.Russian.EntryTypeId.Single30;
                
            case "SE90":
                return Visas.Russian.EntryTypeId.Single90;
                
            case "DE30":
                return Visas.Russian.EntryTypeId.Double30;
                
            case "DE90":
                return Visas.Russian.EntryTypeId.Double90;
                
            case "ME06":
                return Visas.Russian.EntryTypeId.Multiple06;
                
            case "ME12":
                return Visas.Russian.EntryTypeId.Multiple12;
                
            case "ME2Y":
                return Visas.Russian.EntryTypeId.Multi2Years;
                
            case "ME3Y":
                return Visas.Russian.EntryTypeId.Multi3Years;
                
            case "ME5Y":
                return Visas.Russian.EntryTypeId.Multi5Years;
                
            
        }

        var entryTypeId = parseInt(val);
        if (!isNaN(entryTypeId))
            return entryTypeId;

        throw new Error();
    }

   
    function parseVSDServiceTypeId(val) {
        
        switch (val) {
            case "0":
                return null;
                
            case "12":
                return Visas.Russian.VisaSupportServiceTypeId.x12WorkingDays;
                
            case "8":
                return Visas.Russian.VisaSupportServiceTypeId.x8WorkingDays;
                
            case "5":
                return Visas.Russian.VisaSupportServiceTypeId.x5WorkingDays;
                
            case "3":
                return Visas.Russian.VisaSupportServiceTypeId.x3WorkingDaysTelex;
                
            case "2":
                return Visas.Russian.VisaSupportServiceTypeId.x2WorkingDaysTelex;
                
            case "1":
                return Visas.Russian.VisaSupportServiceTypeId.x1WorkingDay;
                
            case "18":
                return Visas.Russian.VisaSupportServiceTypeId.x18WorkingDays;
                
            case "14":
                return Visas.Russian.VisaSupportServiceTypeId.x14WorkingDays;
                
            case "12T":
                return Visas.Russian.VisaSupportServiceTypeId.x12WorkingDaysTelex;
                
            case "46":
                return Visas.Russian.VisaSupportServiceTypeId.x46WorkingDays;
                
            case "TIN":
                return Visas.Russian.VisaSupportServiceTypeId.TIN;

        }

        var visaSupportServiceId = parseInt(val);
        if (!isNaN(visaSupportServiceId))
            return visaSupportServiceId;

        throw new Error("Incorrect VSD service");
    }


    function parseVisaServiceTypeId(val) {
        
        var visaServiceTypeId = parseInt(val);
        if (!isNaN(visaServiceTypeId))
            return visaServiceTypeId;

        switch (val) {
            case "CheckPrepare":
                visaServiceTypeId = Visas.Russian.ServiceTypeId.CheckPrepare;
                break;
            case "Managed":
                visaServiceTypeId = Visas.Russian.ServiceTypeId.Managed;
                break;
            default:
                throw new Error();
        }
        return visaServiceTypeId;
    }

    function parseConsulateServiceTypeId(code) {

        switch (code) {
            case "5":
            case "Standard":
                return Visas.Russian.ConsulateServiceTypeId.Standard;
                
            case "S":
            case "Express":
                return Visas.Russian.ConsulateServiceTypeId.Express;

        }

        var consularServiceTypeId = parseInt(code);
        if (!isNaN(consularServiceTypeId))
            return consularServiceTypeId;
        
        throw new Error("Incorrect consular service");
    }

    Type.registerNamespace("Visas.Russian.Pages.BusinessInformation");
    Visas.Russian.Pages.BusinessInformation.OrderTablesUpdater = function (options) {
        var self = this;
        this.options = options;

        var citizenship$ = options.$citizenship;
        var answer$ = options.$answer;

        this.options.a$ = this.options.$tables.find("a");
        this.options.exclusiveTables$ = this.options.$tables.filter("[data-vsd-service='TIN']");
        this.options.standardTables$ = this.options.$tables.not(this.options.exclusiveTables$);

        citizenship$.change(function onCitizenshipChanged() {

            //cache parameters to reduce invokes
            var val = $(this).val();
            if (onCitizenshipChanged.cacheParamValue === val)
                return;
            onCitizenshipChanged.cacheParamValue = val;

            self.Update();
        });
        answer$.change(function onAnswerChanged() {
            //cache parameters to reduce invokes of the method
            var val = $(this).val();
            if (onAnswerChanged.cacheParamValue === val)
                return;
            onAnswerChanged.cacheParamValue = val;

            self.UpdateAvailableServices();
            self.UpdateVisaServiceProcessingDaysTitles();
        });

        this.Update();
    };
    Visas.Russian.Pages.BusinessInformation.OrderTablesUpdater.prototype = {
        UpdateVisaServiceProcessingDaysTitles: function () {

            var dateCalculatorProxy = this.options.dateCalculatorProxy;
            var ruleChecker = this.options.ruleChecker;
            var exclusiveTables$ = this.options.exclusiveTables$;
            var standardTables$ = this.options.standardTables$;

            var citizenship = this.options.$citizenship.val();
            if (!citizenship)
                return;

            var hasUKResidence = this.options.$answer.filter(":checked").val() === "Yes";
            
            
            var consularProcessingDaysSettingsPromise = dateCalculatorProxy.GetConsularProcessingDaysSettings({
                citizenship: citizenship,
                visaTypeId: Visas.Russian.VisaTypeId.Business
            });

            var groupIdsPromise = ruleChecker.GetCitizenshipGroupsIds(citizenship);

            $.when(consularProcessingDaysSettingsPromise, groupIdsPromise).done(function (settings, ids) {
                if (!settings)
                    return;

                exclusiveTables$.each(function (index) {
                    index++;
                    var $priceTable = $(this);
                    var entryTypeIds;
                    if (index % 1 === 0)
                        entryTypeIds = [Visas.Russian.EntryTypeId.Single30, Visas.Russian.EntryTypeId.Single90];
                    else if (index % 2 === 0)
                        entryTypeIds = [Visas.Russian.EntryTypeId.Double30, Visas.Russian.EntryTypeId.Double90];
                    else
                        entryTypeIds = [
                            Visas.Russian.EntryTypeId.Multiple06, Visas.Russian.EntryTypeId.Multiple12,
                            Visas.Russian.EntryTypeId.Multi2Years, Visas.Russian.EntryTypeId.Multi2Years,
                            Visas.Russian.EntryTypeId.Multi5Years
                        ];
                    var setting = settings.find(function (x) {
                        return x.ConsulateServiceTypeId === Visas.Russian.ConsulateServiceTypeId.Standard &&
                            x.VisaSupportServiceTypeId === Visas.Russian.VisaSupportServiceTypeId.TIN &&
                            entryTypeIds.contains(x.EntryTypeId);
                    });
                    if (!setting) {
                        setting = settings.find(function (x) {
                            return x.Citizenships.length > 0;
                        });
                    }

                    if (setting) {
                        $("tbody tr:nth-child(2) th:nth-child(2)", $priceTable)
                            .html("Standard<br>(" + setting.ProcessingDays + " working days)");
                    }
                });

                standardTables$.each(function () {
                    var $priceTable = $(this);

                    var setting = settings.find(function (x) {
                        return x.ConsulateServiceTypeId === Visas.Russian.ConsulateServiceTypeId.Standard;
                    });
                    if (setting) {
                        $("tbody tr:nth-child(2) th:nth-child(2)", $priceTable)
                            .html("Standard<br>(" + setting.ProcessingDays + " working days)");
                    }

                    setting = settings.find(function (x) {
                        return x.ConsulateServiceTypeId === Visas.Russian.ConsulateServiceTypeId.Express;
                    });

                    if (setting) {
                        $("tbody tr:nth-child(2) th:nth-child(3)", $priceTable)
                            .html("Express<br>(" + setting.ProcessingDays + " working days)");
                    }

                    if (ids && ruleChecker.IsCountryInGroup("Standard10x14CD", ids)) {
                        if (!hasUKResidence) {
                            $("tbody tr:nth-child(2) th:nth-child(2)", $priceTable)
                                .html("Standard<br>(11 - 21 working days)");
                        }
                    }

                });
            });
        },
        UpdateToolTips: function () {
            var self = this;
            
            var citizenship = self.options.$citizenship.val();
            if (!citizenship)
                return;
            
            this.options.a$.tooltipProcessingTime({
                async: true,
                forceImmediatelyShow: true,
                GetHtml: function ($el, callback) {

                    var init = function () {
                        $el.off("mouseover", init);

                        var context = getLinkContext($el);
                        var entryTypeId = context.entryTypeId;
                        var visaSupportServiceId = context.vsdServiceTypeId;
                        var consulateServiceTypeId = context.consularServiceTypeId;
                        var visaServiceTypeId = context.visaServiceTypeId;

                        var message;
                        if (!visaSupportServiceId) {
                            message =
                                "Assuming that you apply online, pay and submit your documents including your biometrics to the Russian visa application centre tomorrow before 15:00 GMT ";
                        } else {
                            var passportTxt = "";
                            if (visaSupportServiceId !== Visas.Russian.VisaSupportServiceTypeId.TIN) {
                                passportTxt = "and email us your passport scan ";
                            }
                            message = "Assuming that you apply online, pay " + passportTxt + "today by ";


                            if (visaSupportServiceId.IsTelexVisaSupportService()) {
                                message += "13:00 GMT";
                            } else if (visaSupportServiceId === Visas.Russian.VisaSupportServiceTypeId.x8WorkingDays ||
                                visaSupportServiceId === Visas.Russian.VisaSupportServiceTypeId.x14WorkingDays) {
                                message += "14:00 GMT";
                            } else {
                                message += "16:30 GMT";
                            }

                            message +=
                                " as well as that you will provide your documents including your biometrics to the Russian visa application centre before 15:00 GMT the day after ";

                            if (!visaSupportServiceId.IsTelexVisaSupportService()) {
                                message += "we receive your visa support document in our London office";
                            } else {
                                message += "your Telex invitation will reach the consulate";
                            }
                        }
                        message += " (if that is their working day), this visa should be ready ";

                        var onOrBy = "on";
                        if (visaSupportServiceId) {
                            if (entryTypeId === Visas.Russian.EntryTypeId.Multiple06 ||
                                entryTypeId === Visas.Russian.EntryTypeId.Multiple12) {
                                if (!visaSupportServiceId.IsTelexVisaSupportService())
                                    onOrBy = "on or by ";
                            }
                        }

                        message += onOrBy;

                        self.options.dateCalculatorProxy.GetOrderDueDate({
                                citizenship: citizenship,
                                visaTypeId: Visas.Russian.VisaTypeId.Business,
                                entryTypeId: entryTypeId,
                                vsdServiceTypeId: visaSupportServiceId,
                                visaServiceTypeId: visaServiceTypeId,
                                consulateServiceTypeId: consulateServiceTypeId,
                                dispatchType: Visas.Russian.DispatchType.Electronic,
                                deliveryTypeId: null,
                                consulate: null,
                                hasUKResidence: true
                            },
                            function(date) {
                                message += " <strong>" + date.format("dd MMMM yyyy") + "</strong>";
                                callback(message);
                            });
                    };

                    $el.on("mouseover", init);
                }
            });
        },
        Update: function () {
            this.UpdateToolTips();
            this.UpdatePriceTablesAvailability();
            this.UpdateVisaServiceProcessingDaysTitles();
            this.UpdatePrices();
            this.UpdateAvailableServices();
        },
        UpdatePrices: function () {
            var citizenship$ = this.options.$citizenship;
            var a$ = this.options.a$;

            var priceServiceProxy = this.options.priceServiceProxy;

            var citizenship = citizenship$.val();

            function updateLinks(orderPrices) {
                if (!orderPrices) {
                    a$.html("unknown price");
                    return;
                }

                a$.each(function() {
                    var link$ = $(this);
                    var context = getLinkContext(link$);

                    var total = getPrice(orderPrices, context.visaServiceTypeId, context.entryTypeId, context.vsdServiceTypeId, context.consularServiceTypeId);
                    if (!total) {
                        link$.html("unknown price");
                    } else {
                        link$.html("&pound" + total.toFixed(2));
                    }
                });
            };

            if (!citizenship) {
                updateLinks();
                return;
            }


            priceServiceProxy.GetDefaultBusinessOrderPrices(citizenship, function (orderPrices) {
                updateLinks(orderPrices);
            });
        },
        UpdateAvailableServices: function () {
            var ruleChecker = this.options.ruleChecker;

            var citizenship = this.options.$citizenship.val();
            if (!citizenship)
                return;

            var hasUKResidence = this.options.$answer.filter(":checked").val() === "Yes";
            var visaTypeId = Visas.Russian.VisaTypeId.Business;

            this.options.a$.each(function () {
                var $currentLink = $(this);

                var context = getLinkContext($currentLink);


                var entryTypeId = context.entryTypeId;
                var visaSupportServiceTypeId = context.vsdServiceTypeId;
                var visaServiceTypeId = context.visaServiceTypeId;
                var consulateServiceTypeId = context.consularServiceTypeId;

                var conditionRules = [Visas.Russian.Rules.Condition.CountryResidence];
                if (hasUKResidence) {
                    conditionRules.push(Visas.Russian.Rules.Condition.UKResidence);
                }

                ruleChecker.IsServiceAvailable(citizenship,
                    visaTypeId,
                    entryTypeId,
                    visaSupportServiceTypeId,
                    consulateServiceTypeId,
                    conditionRules,
                    true, function (res) {
                        if (res) {
                            //customize for telex
                            if (visaSupportServiceTypeId === Visas.Russian.VisaSupportServiceTypeId.x12WorkingDaysTelex ||
                                visaSupportServiceTypeId === Visas.Russian.VisaSupportServiceTypeId.x46WorkingDays) {
                                $currentLink
                                    .removeClass("text-muted")
                                    .off("click");
                                return;
                            }
                            //else
                            $currentLink.parent().find("span").remove();
                            $currentLink.show();
                        } else {
                            $currentLink.hide();
                            $currentLink.parent().find("span").remove();
                            $("<span class=\"text-muted\">not available</span>").appendTo($currentLink.parent());
                        }
                    });

            });
        },
        UpdatePriceTablesAvailability: function () {
            var options = this.options;

            function getElement(element, getDefaultElement, root$) {
                var el$ = options.elements && options.elements[element];
                if (!(el$ instanceof jQuery)) {
                    if (root$ && root$.length)
                        el$ = root$.find(el$);
                    else
                        el$ = $(el$);
                }
                if ((!el$ || !el$.length) && getDefaultElement)
                    el$ = getDefaultElement();

                return el$;
            }


            var detailedServiceSection$ = getElement("detailedServiceSection$", function() {
                return $(".DnnModule-1845");
            }, null);
            var tinSections$ = getElement("tinSections$", null, null);

            var collapsePanelLinks$ = getElement("collapsePanelLinks$", function () {
                return $("#dnn_ctr1844_ContentPane .ICG_ETH_Title a.expandTitle");
            }, detailedServiceSection$);

            function triggerClickOnLink(link$) {
                var link = link$[0];
                link.click.apply(link);
            }

            function isPriceTableCollapsed(link$) {
                //dnn html expandable module
                var expandContent_clean$ = link$.parent().parent().next(".expandContent_clean");
                if (expandContent_clean$.length) {
                    var container$ = expandContent_clean$.children().first();
                    return container$.attr("class") === "hideContent";
                }
                //bootstrap collapse
                var panel_collapse$ = link$.parent().parent().next(".panel-collapse");
                if (panel_collapse$.length) {
                    return !panel_collapse$.hasClass("in");
                }
                return true;
            }

            function disablePriceTable(link$) {
                if (!isPriceTableCollapsed(link$))
                    triggerClickOnLink(link$);

                if (!link$.data("href")) {
                    var curHref = link$.attr("href");
                    link$.data("href", curHref);
                }
                link$.on("click", function () {
                    alert("Please select citizenship");
                    return false;
                });
            }

            function enablePriceTable(link$) {
                link$.off("click");
                var curHref = link$.data("href");
                link$.attr("href", curHref);
            }

            function showPriceTable(link$) {
                var title$ = link$.parent().parent();
                title$.show();

                var content$ = title$.next(".expandContent_clean");
                content$.show();
            }

            function hidePriceTable(link$) {
                var title$ = link$.parent().parent();
                title$.hide();

                var content$ = title$.next(".expandContent_clean");
                content$.hide();
            }

            function hideTINSection() {
                tinSections$.hide();
                $("[data-citizenship]").text("");
            }

            function showTINSection(citizenship) {
                var introduceText$ = tinSections$.find(".introduce-text");
                if (citizenship === "United States") {
                    introduceText$.html("<p>The following visa services are provided under a special visa simplification agreement between Russia and United States. The visa support documents only take one day to issue meaning that the whole process is far quicker and cheaper than standard visa processing. The visa processing time at the consulate is of 12 working days regardless of the number of entries (consular service in the order table below will reflect this in due course).</p>");
                } else {
                    introduceText$.html("<p>The following visa services are provided under a special visa simplification agreement between Russia and <span class= 'citizenship'></span>. Using this method, there is only one processing time at the consulate, that of 6 working days for single and double entry visa and 11 working days for multiple entry visa. Besides, the visa support documents only take one day to issue meaning that the whole process is far quicker and cheaper than standard visa processing.</p>");
                }

                tinSections$.find("span.citizenship").html(citizenship);
                tinSections$.show("highlight", 3000);
                $("[data-citizenship]").text(citizenship);
            }

            var self = this;
            var $citizenship = this.options.$citizenship;

            //cache links
            if (!this.UpdatePriceTablesAvailability.links$)
                this.UpdatePriceTablesAvailability.links$ = collapsePanelLinks$;

            var citizenship = $citizenship.val();
            if (!citizenship) {
                hideTINSection();

                this.UpdatePriceTablesAvailability.links$.each(function () {
                    disablePriceTable($(this));
                });
                return;
            }

            var hasUKResidence = this.options.$answer.filter(":checked").val() === "Yes";
            var conditionRules = [Visas.Russian.Rules.Condition.CountryResidence];
            if (hasUKResidence) {
                conditionRules.push(Visas.Russian.Rules.Condition.UKResidence);
            }

            detailedServiceSection$.block();
            self.options.ruleChecker.IsServiceAvailable(
                citizenship,
                Visas.Russian.VisaTypeId.Business,
                Visas.Russian.EntryTypeId.Single30,
                Visas.Russian.VisaSupportServiceTypeId.TIN,
                null,
                conditionRules,
                true, function (res) {
                    if (res) {
                        showTINSection(citizenship);
                    } else {
                        hideTINSection();
                    }
                    detailedServiceSection$.unblock();
                });

            this.UpdatePriceTablesAvailability.links$.each(function () {
                enablePriceTable($(this));
            });
        }
    };
    Visas.Russian.Pages.BusinessInformation.OrderTablesUpdater.Run = function (options) {
        Visas.Russian.Pages.BusinessInformation.OrderTablesUpdater.Current =
            new Visas.Russian.Pages.BusinessInformation.OrderTablesUpdater(options);
    };
    Visas.Russian.Pages.BusinessInformation.OrderTablesUpdater.registerClass("Visas.Russian.Pages.BusinessInformation.OrderTablesUpdater");

})(jQuery);
