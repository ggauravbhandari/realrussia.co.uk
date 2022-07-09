/// <reference path="http://ajax.aspnetcdn.com/ajax/4.0/1/MicrosoftAjax.js" />
/// <reference path="../incl/scripts/common.js" />
/// <reference path="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.7.1.js" />
/// <reference path="../incl/scripts/jquery.blockUI.js" />
/// <reference path="../incl/scripts/infrastructure.data.js" />
/// <reference path="http://visas.realrussia.local/russian/scripts/visas.russian.js" />
/// <reference path="http://visas.realrussia.local/russian/scripts/visas.russian.prices.js" />
/// <reference path="../incl/scripts/linq.min.js" />
/// <reference path="http://visas.realrussia.local/scripts/realrussia.js" />
/// <reference path="../incl/scripts/jsextends.js" />
/// <reference path="http://visas.realrussia.local/russian/scripts/Visas.Russian.DateCalculating.js" />
/// <reference path="../incl/scripts/rr.ui.js" />
/// <reference path="http://visas.realrussia.local/Russian/Areas/Rules/Scripts/Visas.Russian.Rules.js" />
/// <reference path="https://visas.realrussia.local/inc/scripts/Visas.Russian.UI.js" />

(function ($) {

    function CitizenshipSectionComponent(options) {
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
        

        function updateInformationBlock(country) {
            if (!country || country === "Please select")
                return;

            additionalInfo$.hide();
            section$.hide();

            answerYes$.prop("checked", true);

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

                        if (ruleChecker.IsCountryInGroup("TouristVisaFree", ids)) {
                            texts = "Citizens of " + country + " do not require a tourist visa to visit the Russian Federation";
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

                            if (country === "Brazil") {
                                texts =
                                    "Citizens of Brazil do not require a visa to visit the Russian Federation for tourist, transit and private purposes for up to 90 days in any 180-day period starting from the day of the first entry.";
                            } else if (country === "Bosnia and Herzegovina") {
                                texts =
                                    "Citizens of Bosnia and Herzegovina do not require a tourist visa to visit the Russian Federation for up to 30 days in any 60-day period; however, it is necessary to present the original visa support documents (invitation) to the immigration authorities at passport control on arrival. The maximum period of visa-free stay in the course of multiple visits cannot exceed 90 days in any 180-day period starting from the day of the first entry.";
                            } else if (country === "Hong Kong") {
                                texts =
                                    "Holders of Hong Kong Special Administrative Region passport do not require a tourist visa to visit the Russian Federation for up to 14 days. If you wish to stay in the country for more than 14 days (up to 30 days maximum), you would still require the visa. The maximum period of visa-free stay in the course of multiple visits cannot exceed 90 days in any 180-day period starting from the day of the first entry.";
                            } else if (country === "Israel") {
                                texts =
                                    "Israeli nationals do not require a tourist visa to visit the Russian Federation for up to 90 days; however, it is necessary to present the visa support documents (tourist voucher/confirmation) to the immigration authorities at passport control on arrival. The maximum period of visa-free stay in the course of multiple visits cannot exceed 90 days in any 180-day period starting from the day of the first entry.";
                            } else if (country === "Macedonia") {
                                texts =
                                    "Citizens of Macedonia do not require a tourist visa to visit the Russian Federation for up to 30 days; however, it is necessary to present the original visa support documents (tourist voucher/confirmation) to the immigration authorities at passport control on arrival. The maximum period of visa-free stay in the course of multiple visits cannot exceed 90 days in any 180-day period starting from the day of the first entry.";
                            } else if (country === "Serbia") {
                                texts =
                                    "Citizens of Serbia with biometric passports obtained after April 9th, 2008 do not require a tourist visa to visit the Russian Federation for up to 30 days. Serbian nationals with temporary and permanent resident permits can stay without time limits. In all other cases visa is required. Visa free regime does not apply for Yugoslavian passports holders. Please note that the maximum period of visa-free stay for biometric passport holders in the course of multiple visits cannot exceed 90 days in any 180-day period starting from the day of the first entry.";
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
            var citizenship = $(this).val();
            updateInformationBlock(citizenship);
        });

        //init
        visaFreeQuestion$.hide();
        section$.hide();
        additionalInfo$.hide();
        answerYes$.prop("checked", true);

        updateInformationBlock(citizenship$.val());
    };

    CitizenshipSectionComponent.Run = function(options) {
        CitizenshipSectionComponent.Current = new CitizenshipSectionComponent(options);
    };


    function DocumentRequirementsComponent(options) {
        var nationalityRequirements$ = options.elements.nationalityRequirements$;
        var citizenship$ = options.elements.citizenship$;

        function updateRussianRequirements(country) {

            var countryLabel = "<h5>Documents required for passport holders of " + country + ":</h5>",
                forWhat = "notemail",
                visatype = "",
                sdm = "",
                age = 0,
                purpose = "",
                url = visasHostUrl + "/inc/showRequirements.asp" + "?country=" + encodeURIComponent(country) + "&forWhat=" + forWhat + "&visatype=" + visatype + "&sdm=" + sdm + "&age=" + age + "&purpose=" + purpose;

            //get the data via ajax
            nationalityRequirements$.load(url, function () {
                nationalityRequirements$.prepend(countryLabel);
            });
        }

        citizenship$.change(function () {
            updateRussianRequirements($(this).val());
        });

        //init
        nationalityRequirements$.show();

        updateRussianRequirements(citizenship$.val());
    };

    DocumentRequirementsComponent.Run = function(options) {
        DocumentRequirementsComponent.Current = new DocumentRequirementsComponent(options);
    };

    function OrderTableUpdater(options) {
        var self = this;
        this.options = options;

        if (this.options.elements.citizenship$.length === 0)
            return;

        this.options.$links = this.options.elements.$priceTable.find("td a");

        this.options.elements.citizenship$.change(function () {
            self.Update();
        });
        this.options.elements.hasUKResidence$.change(function () {
            self.UpdateAvailableServices();
            self.UpdateVisaServiceProcessingDaysTitles();
            self.UpdateUrlLinks();
        });

        this.Update();
    };
    OrderTableUpdater.prototype = {
        UpdateVisaServiceProcessingDaysTitles: function () {
            var self = this;
            //refactor
            var citizenship = self.options.elements.citizenship$.val();

            var standardServiceRow = self.options.elements.$priceTable[0].getElementsByTagName("TBODY")[0].getElementsByTagName("TR")[1];
            var tds = standardServiceRow.getElementsByTagName("TD");
            var _standardServiceProcessingDaysTD = tds[tds.length - 1];

            var expressServiceRow = self.options.elements.$priceTable[0].getElementsByTagName("TBODY")[0].getElementsByTagName("TR")[2];
            tds = expressServiceRow.getElementsByTagName("TD");
            var _expressServiceProcessingDaysTD = tds[tds.length - 1];


            self.options.dateCalculatorProxy.GetConsularProcessingDays(
                {
                    citizenship: citizenship,
                    visaTypeId: Visas.Russian.VisaTypeId.Tourist
                }, function (res) {
                if (!res)
                    return; 

                if (res[0]) {
                    var standardProcessingDaysText = res[0] + " working days";
                    _standardServiceProcessingDaysTD.innerText = standardProcessingDaysText;
                }

                if (res[1]) {
                    var expressProcessingDaysText = res[1] + " working days"; 
                    _expressServiceProcessingDaysTD.innerText = expressProcessingDaysText;
                }
            });

            //case 14690: If the customer responds �no�, instead of showing a standard service of 21 working days, it should be 11 � 21 working days
            var _ids;
            self.options.ruleChecker.GetCitizenshipGroupsIds(citizenship, function (ids) {
                _ids = ids;  
            }, function () {
                alert("Error");
            });
            if (_ids && self.options.ruleChecker.IsCountryInGroup("Standard10x14CD", _ids)) {
                var answer = $("[name='answer']:checked:visible").val();
                if (answer === "No") {
                    _standardServiceProcessingDaysTD.innerText = "11 - 21 working days";
                }
            }

            self.options.ruleChecker.IsCountryInGroup(citizenship, "NoExpressWithoutUKResidence", function (res) {
                if (res) {
                    _standardServiceProcessingDaysTD.innerText = "up to 21 working days";
                }
            });

        },
        UpdateToolTips: function () {
            var self = this;
            var citizenship = self.options.elements.citizenship$.val();
            this.options.$links.tooltipProcessingTime({
                async: true,
                GetHtml: function ($el, callback) {
                    var entryTypeId;
                    var href = $el.attr("href");
                    var entryPart = href.split("service=")[1].substring(0, 2);
                    switch (entryPart) {
                        case "SE":
                            entryTypeId = Visas.Russian.EntryTypeId.Single;
                            break;
                        case "DE":
                            entryTypeId = Visas.Russian.EntryTypeId.Double;
                            break;
                        default:
                            throw new Error();
                    }
                    var servicePart = href.split("service=")[1].substring(3, 5);
                    var consulateServiceTypeId;
                    switch (servicePart) {
                        case "ST":
                            consulateServiceTypeId = Visas.Russian.ConsulateServiceTypeId.Standard;
                            break;
                        case "SA":
                            consulateServiceTypeId = Visas.Russian.ConsulateServiceTypeId.Express;
                            break;
                        default:
                            throw new Error();
                    }
                    self.options.dateCalculatorProxy.GetDefaultTouristOrderDueDate(citizenship, entryTypeId, consulateServiceTypeId, function (date) {
                        var message = "Assuming that you apply online, pay and submit your documents including your biometrics to the Russian visa application centre tomorrow before 15:00 GMT (if that is their working day), this visa should be ready on <strong>" + date.format("dd MMMM yyyy") + "</strong>";
                        callback(message);
                    });
                }
            });
        },
        Update: function () {
            this.UpdateToolTips();
            this.UpdateVisaServiceProcessingDaysTitles();
            this.UpdatePrices();
            this.UpdateAvailableServices();
        },
        UpdatePrices: function () {
            var self = this;
            var citizenship = this.options.elements.citizenship$.val();

            var updateLinks = function (orderPrices) {
                var enumerablePrices = Enumerable.From(orderPrices);
                self.options.$links.each(function () {
                    var $link = $(this);

                    var link = this;

                    if (link.parentNode.nodeName === "TH") {
                        return;
                    }

                    var entryTypeId = getEntryTypeByHref(link.href);
                    var consulateServiceTypeId = getConsulateServiceTypeByHref(link.href);

                    var price = enumerablePrices.SingleOrDefault(null, function (x) {
                        return x.ConsulateServiceTypeId === consulateServiceTypeId && x.EntryTypeId === entryTypeId;
                    });
                    
                    if (price != null) {
                        $link.html("&pound" + price.Total.toFixed(2));
                    } else {
                        $link.html("unknown price");
                    }
                });
                self.UpdateUrlLinks();
            };

            if (!citizenship) {
                updateLinks();
                return;
            }

            this.options.elements.$priceTable.block();
            this.options.priceServiceProxy.GetDefaultTouristOrderPrices(citizenship, function (orderPrices) {
                updateLinks(orderPrices);
                self.options.elements.$priceTable.unblock();
            });
        },
        UpdateUrlLinks: function () {
            var citizenship = this.options.elements.citizenship$.val();
            var hasUKResidence = this.options.elements.hasUKResidence$.filter(":checked").val() === "Yes";
            this.options.$links.each(function () {
                var $link = $(this);

                var link = this;

                if (link.parentNode.nodeName === "TH") {
                    return;
                }

                if (!citizenship)
                    return;

                var href = $link.attr("href");
                if (/citizenship/.test(href))
                    href = href.replace(/citizenship\=(.*)/, "citizenship=" + citizenship);
                else
                    href += "&citizenship=" + citizenship;

                if (hasUKResidence) {
                    if (/hasUKResidence/.test(href)) {
                        href = href.replace(/&hasUKResidence\=?(.*)/, ""); //remove
                    }
                } else {
                    if (!(/hasUKResidence/.test(href))) {
                        href += "&hasUKResidence=0";
                    }
                }

                $link.attr("href", href);
            });
        },
        UpdateAvailableServices: function () {
            var self = this;
            var citizenship = this.options.elements.citizenship$.val();
            var hasUKResidence = this.options.elements.hasUKResidence$.filter(":checked").val() === "Yes";

            var visaSupportServiceTypeId = Visas.Russian.VisaSupportServiceTypeId.x1WorkingDay;
            var visaTypeId = Visas.Russian.VisaTypeId.Tourist;
            this.options.$links.each(function () {
                var $currentLink = $(this);

                var code = $currentLink.attr("href");

                var entryTypeId = getEntryTypeByHref(code);
                var visaServiceTypeId = getVisaServiceTypeByHref(code);

                var conditionRules = [Visas.Russian.Rules.Condition.CountryResidence, Visas.Russian.Rules.Condition.BookedOtherService];
                if (hasUKResidence) {
                    conditionRules.push(Visas.Russian.Rules.Condition.UKResidence);
                }
                self.options.elements.$priceTable.block();
                self.options.ruleChecker.IsServiceAvailable(citizenship,
                    visaTypeId,
                    entryTypeId,
                    visaSupportServiceTypeId,
                    visaServiceTypeId,
                    conditionRules,
                    true,
                    function (res) {
                        if (res) {
                            $currentLink.parent().find("span").remove();
                            $currentLink.show();
                        } else {
                            $currentLink.hide();
                            $currentLink.parent().find("span").remove();
                            $("<span class=\"disable\">not available</span>").appendTo($currentLink.parent());
                        }
                        self.options.elements.$priceTable.unblock();
                    });
            });
        }
    };
    OrderTableUpdater.Run = function (options) {
        OrderTableUpdater.Current = new OrderTableUpdater(options);
    };

    function PageComponent(options) {
        Visas.Russian.UI.ServicesSectionComponent.Run(options);
        Visas.Russian.UI.ProcessingSpeedComponent.Run(options);

        CitizenshipSectionComponent.Run(options);
        DocumentRequirementsComponent.Run(options);
        //OrderTableUpdater.Run(options);
    }
    PageComponent.Run = function(options) {
        PageComponent.Current = new PageComponent(options);
    };
    if (Sys) {
        Type.registerNamespace("Visas.Russian.UI.TouristInformationPage");

        CitizenshipSectionComponent.registerClass("CitizenshipSectionComponent");
        Visas.Russian.UI.TouristInformationPage.CitizenshipSectionComponent = CitizenshipSectionComponent;
        Visas.Russian.UI.TouristInformationPage.CitizenshipSectionComponent.registerClass("Visas.Russian.UI.TouristInformationPage.CitizenshipSectionComponent");

        DocumentRequirementsComponent.registerClass("DocumentRequirementsComponent");
        Visas.Russian.UI.TouristInformationPage.DocumentRequirementsComponent = DocumentRequirementsComponent;
        Visas.Russian.UI.TouristInformationPage.DocumentRequirementsComponent.registerClass("Visas.Russian.UI.TouristInformationPage.DocumentRequirementsComponent");

        OrderTableUpdater.registerClass("OrderTableUpdater");
        Visas.Russian.UI.TouristInformationPage.OrderTableUpdater = OrderTableUpdater;
        Visas.Russian.UI.TouristInformationPage.OrderTableUpdater.registerClass("Visas.Russian.UI.TouristInformationPage.OrderTableUpdater");

        PageComponent.registerClass("PageComponent");
        Visas.Russian.UI.TouristInformationPage.PageComponent = PageComponent;
        Visas.Russian.UI.TouristInformationPage.PageComponent.registerClass("Visas.Russian.UI.TouristInformationPage.PageComponent");
    }

    function getEntryTypeByHref(href) {
        href = href.replace("&sameday=false", "");
        var entryTypeId;
        var entryPart = href.split("service=")[1].substring(0, 2);
        switch (entryPart) {
            case "SE":
                entryTypeId = Visas.Russian.EntryTypeId.Single;
                break;
            case "DE":
                entryTypeId = Visas.Russian.EntryTypeId.Double;
                break;
            default:
                throw new Error();
        }
        return entryTypeId;
    }

    function getVisaServiceTypeByHref(href) {
        href = href.replace("&sameday=false", "");

        var servicePart = href.split("service=")[1].substring(3, 5);
        var serviceTypeId;
        switch (servicePart) {
            case "ST":
                serviceTypeId = Visas.Russian.ServiceTypeId.Standard;
                break;
            case "BR":
                serviceTypeId = Visas.Russian.ServiceTypeId.Bronze;
                break;
            case "SA":
                serviceTypeId = Visas.Russian.ServiceTypeId.NextDay;
                break;
            default:
                throw new Error();
        }
        return serviceTypeId;
    }

    function getConsulateServiceTypeByHref(href) {
        href = href.replace("&sameday=false", "");

        var servicePart = href.split("service=")[1].substring(3, 5);
        var consulateServiceTypeId;
        switch (servicePart) {
        case "ST":
            consulateServiceTypeId = Visas.Russian.ConsulateServiceTypeId.Standard;
            break;
        case "SA":
            consulateServiceTypeId = Visas.Russian.ConsulateServiceTypeId.Express;
            break;
        default:
            throw new Error("Incorrect consulate service type");
        }
        return consulateServiceTypeId;
    }

    var visasHostUrl = "//visas.realrussia.co.uk"; //RRHelper.GetVisasHostname();
    var proxyOptions = {
        hostUrl: visasHostUrl
    };

    var dateCalculatorProxy = new Visas.Russian.DateCalculating.DateCalculatorProxy(visasHostUrl + "/Russian/", {
        jsonp: true
    });
    var priceService = new Visas.Russian.Prices.PriceServiceProxy(null, proxyOptions);
    var ruleChecker = new Visas.Russian.Rules.RuleChecker(proxyOptions);

    $(function () {

        var $nationalitySelectDD = $(".nationalitySelectDD");
        $nationalitySelectDD.replicateChanges();               

        if (!Modernizr.inputtypes.date) {            
            $("input[type='date']").datepicker({
                dateFormat: "yy-mm-dd"
            }).keypress(function (e) {
                e.preventDefault();
            });
        }

        var elements = {
            citizenship$: $nationalitySelectDD,
            hasUKResidence$: $("[name=hasUKResidence]"),
            nationalityRequirements$: $("#nationalityRequirements"),
            $priceTable: $("#priceTable"),
            tourDate$: $("#tourDate"),
            consulateCity$: $("#consulateCity"),
            consularServiceType$: $("#consularServiceType"),
            entryType$: $("#entryType")
        };

        PageComponent.Run({
            elements: elements,
            ruleChecker: ruleChecker,
            dateCalculatorProxy: dateCalculatorProxy,
            priceServiceProxy: priceService,
            visaTypeId: Visas.Russian.VisaTypeId.Tourist,
            rules: {
                servicesBCAreAvailableOnlyForUK: true,
                serviceCAvailableOnlyInLondon: true
            }
        });

    });

    return {
        PageComponent: PageComponent
    }
})(jQuery);