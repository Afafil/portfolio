/**
 * Created by Alice on 8/23/2017.
 */

(function () {
'use strict';

    angular.module('DecisionsListApp', [])
        .controller('DecisionsListAddController', DecisionsListAddController)
        .controller('DecisionsListShowController', DecisionsListShowController)
        .service('DecisionsListService', DecisionsListService);

    DecisionsListAddController.$inject = ['DecisionsListService'];
    function DecisionsListAddController(DecisionsListService) {
        var itemAdder = this;

        itemAdder.itemName = "";

        itemAdder.addItem = function () {
            if (itemAdder.itemName != "") {

                DecisionsListService.addItem(itemAdder.itemName);
                itemAdder.itemName = "";
            } else {
                DecisionsListService.addItem("You fogot to write something");
            }
        }
    }


    DecisionsListShowController.$inject = ['DecisionsListService'];
    function DecisionsListShowController(DecisionsListService) {
        var showList = this;

        showList.items = DecisionsListService.getItems();
        showList.answer = "";
        showList.counter = 0;

        showList.removeItem = function (itemIndex) {
            DecisionsListService.removeItem(itemIndex);
        };

        showList.makeChoice = function () {

            if (showList.items.length == 0) {
                showList.answer = "There are no any decisions for making choice. Please add some with '+' button";
                //document.getElementById("content").innerHTML = "<h3>There are no any decisions for making choice</h3><p>Please add some with 'Add solution to decision list' button</p>";
                return (null);
            }

            // showList.counter++;
            // if (showList.counter > 3) {
            // 	showList.answer = "Do you think it is wrong solution? Than you know better what is right!";
            // 	message += "<p></p><p>Do you think it is wrong solution? Than you know better what is right!</p>";
            // 	document.getElementById("content").innerHTML = message;
            // 	return(null);
            // }

            var rand = showList.items[Math.floor(Math.random() * showList.items.length)];
            var message = document.getElementById("content").innerHTML;

            message += "<h2>We think all you need is:</h2><p>" + rand.name + "</p>";
            showList.answer = "We think all you need is: " + rand.name;
            // document.getElementById("content").innerHTML = message;

        }
    }


    function DecisionsListService() {
        var service = this;

        // List of Decisions items
        var items = [];

        service.addItem = function (itemName, quantity) {
            var item = {
                name: itemName,
                quantity: quantity
            };
            items.push(item);
        };

        service.removeItem = function (itemIdex) {
            items.splice(itemIdex, 1);
        };

        service.getItems = function () {
            return items;
        };

        service.makeChoice = function () {
            //
            //
        }
    }

})();
