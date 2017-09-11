/**
 * Created by Alice on 9/8/2017.
 */
(function () {
'use strict';

var actual_JSON;

angular.module('ShoppingListCheckOff', [])
  .controller('ToBuyController', ToBuyController)
  .controller('AlreadyBoughtController', AlreadyBoughtController)
  .controller('AddItemsController', AddItemsController)
  .service('ShoppingListService', ShoppingListService);


AddItemsController.$inject = ['ShoppingListService'];
function AddItemsController(ShoppingListService) {
  var itemAdder = this;

    itemAdder.itemName = "";
    itemAdder.itemQuantity = "";

    itemAdder.addItem = function () {
        ShoppingListService.addItem(itemAdder.itemName, itemAdder.itemQuantity);
        itemAdder.itemName = "";
        itemAdder.itemQuantity = "";
    };

    itemAdder.showDropdown = function () {
        document.getElementById("myDropdown").classList.toggle("show");
        //var choosenOne =
        ShoppingListService.showDropdown(event);
        //itemAdder.itemName = choosenOne.itemName;
        //itemAdder.itemQuantity = choosenOne.itemQuantity;
    }
}




ToBuyController.$inject = ['ShoppingListService'];
function ToBuyController(ShoppingListService) {

  var ToBuy = this;
  ToBuy.itemsToBuy = ShoppingListService.getItemsToBuy();

  ToBuy.BuyItem = function (itemIndex) {
      ShoppingListService.BuyItem(itemIndex);
  };

  ToBuy.DelItem = function (itemIndex) {
      ShoppingListService.DelItem(itemIndex);
  };
}




AlreadyBoughtController.$inject = ['ShoppingListService'];
function AlreadyBoughtController(ShoppingListService) {

   var AlreadyBought = this;
   AlreadyBought.ItemsBought = ShoppingListService.getItemsBought();

}

function ShoppingListService() {

   var service = this;

    // List of shopping items
    var itemsToBuy = [
        {name: "cookies", quantity: '5 packs'},
        {name: "healthy snacks", quantity: '6 packs'},
        {name: "soda", quantity: '2 bottles'},
        {name: "milk", quantity: '3 bottles'},
        {name: "donuts", quantity: '10 units'}
    ];

    service.addItem = function (itemName, quantity) {
        var item = {
            name: itemName,
            quantity: quantity
        };
        itemsToBuy.push(item);
    };

   var itemsBought = [];

   service.BuyItem = function (itemIndex) {
       // add this item to ItemsBought List and remove from ItemsToBuy
       var item = {
           name: itemsToBuy[itemIndex].name,
           quantity: itemsToBuy[itemIndex].quantity
       };
       itemsBought.push(item);
       itemsToBuy.splice(itemIndex, 1);
   };

   service.DelItem = function (itemIndex) {
       itemsToBuy.splice(itemIndex, 1);
   };

   service.getItemsToBuy = function () {
       return itemsToBuy;
   };

   service.getItemsBought = function () {
       return itemsBought;
   };

   service.showDropdown = function (event) {
       // json file actual_JSON

       if (!event.target.matches('.dropbtn')) {
       //console.log(actual_JSON);
           var dropdowns = document.getElementsByClassName("dropdown-content");
           var i;
           for (i = 0; i < dropdowns.length; i++) {
               var openDropdown = dropdowns[i];
               //console.log(openDropdown);
               if (openDropdown.classList.contains('show')) {
                   openDropdown.classList.remove('show');
               }
           }
       }
   }
}


function loadJSON(file, callback) {

    // This how to load json, using jQuery
    // $.getJSON("demo_ajax_json.js", function(result){
    //     $.each(result, function(i, field){
    //         $("div").append(field + " ");
    //     });
    // });


    // This how to load lson, using only JavaScript
  // var xobj = new XMLHttpRequest();
  // xobj.overrideMimeType("application/json");
  // xobj.open('GET', file, true);
  // xobj.onreadystatechange = function () {
  // if (xobj.readyState == 4 && xobj.status == "200") {
  //   // Required use of an anonymous callback as .open will NOT return a value but simply returns undefined in asynchronous mode
  //   callback(xobj.responseText);
  //   }
  // };
  // xobj.send(null);
}


// $(document).ready(function() {
//
//     // here we make css for imajes. It does not work for now
//
//   var ourWidth = $(".ToBuyListContainer").width();
//   var ourHeight = $(".ToBuyListContainer").height();
//
//   $(".ListMidleTop").css({
//     'width': (ourWidth + "px; height: 115px; background-image: url('../img/NotePageMT.jpg'); position: absolute; top: -115px; left: 0;")
//   });
//   $(".ListLeftMiddle").css({
//     'height': (ourHeight + 'px; width: 75px; background-image: url("../img/NotePageLM.jpg"); position: absolute; top: 0; left: -75px;')
//   });
//
// });



document.addEventListener("DOMContentLoaded",
  function (event) {

    loadJSON("data/items.json", function(response) {
      //var actual_JSON = JSON.parse(response);
      actual_JSON = JSON.parse(response);
      //console.log(actual_JSON);
    });


  }
);


})();
