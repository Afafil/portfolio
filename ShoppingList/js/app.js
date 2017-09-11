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
  .controller('EditItemsController', EditItemsController)
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

  ToBuy.EditItem = function (itemIndex) {
      var name = ToBuy.itemsToBuy[itemIndex].name;
      var quantity = ToBuy.itemsToBuy[itemIndex].quantity;
      //var currentItem =
      ShoppingListService.EditItem(itemIndex, name, quantity);

  }
}


EditItemsController.$inject = ['ShoppingListService'];
function EditItemsController(ShoppingListService) {
    var itemEditor = this;

    itemEditor.EditItem = function (itemIndex) {
        ShoppingListService.EditItemConfirm($(".EditorInputN").val(), $(".EditorInputQ").val(), $(".EditorInputI").val());
    }
}


AlreadyBoughtController.$inject = ['ShoppingListService'];
function AlreadyBoughtController(ShoppingListService) {

   var AlreadyBought = this;
   AlreadyBought.ItemsBought = ShoppingListService.getItemsBought();

}

function ShoppingListService() {

   var service = this;
   var currentItem = {itemName: "", itemQuantity: "", itemIndex: 0};

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


   service.EditItemConfirm = function (itemName, itemQuantity, itemIndex) {
       itemsToBuy[itemIndex].name = itemName;
       itemsToBuy[itemIndex].quantity = itemQuantity;
       $('#modal_form')
          .animate({opacity: 0, top: '45%'}, 200,  // плaвнo меняем прoзрaчнoсть нa 0 и oднoвременнo двигaем oкнo вверх
              function(){ // пoсле aнимaции
                   $(this).css('display', 'none'); // делaем ему display: none;
                   $('#overlay').fadeOut(400); // скрывaем пoдлoжку
              }
          );
   };

   service.EditItem = function (itemIndex, itemName, itemQuantity) {
       currentItem.itemName = itemName;
       currentItem.itemQuantity = itemQuantity;
       currentItem.itemIndex = itemIndex;

       $('#overlay').fadeIn(400, // снaчaлa плaвнo пoкaзывaем темную пoдлoжку
           function(){ // пoсле выпoлнения предъидущей aнимaции
               $('#modal_form')
                   .css('display', 'block') // убирaем у мoдaльнoгo oкнa display: none;
                   .animate({opacity: 1, top: '50%'}, 200); // плaвнo прибaвляем прoзрaчнoсть oднoвременнo сo съезжaнием вниз
               $(".EditorInputN").val(currentItem.itemName);
               $(".EditorInputQ").val(currentItem.itemQuantity);
               $(".EditorInputI").val(itemIndex);
           });
   }

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


$(document).ready(function() {

  //   // here we make css for imajes. It does not work for now
  //
  // var ourWidth = $(".ToBuyListContainer").width();
  // var ourHeight = $(".ToBuyListContainer").height();
  //
  // $(".ListMidleTop").css({
  //   'width': (ourWidth + "px; height: 115px; background-image: url('../img/NotePageMT.jpg'); position: absolute; top: -115px; left: 0;")
  // });
  // $(".ListLeftMiddle").css({
  //   'height': (ourHeight + 'px; width: 75px; background-image: url("../img/NotePageLM.jpg"); position: absolute; top: 0; left: -75px;')
  // });

    /* Зaкрытие мoдaльнoгo oкнa, тут делaем тo же сaмoе нo в oбрaтнoм пoрядке */
    $('#modal_close, #overlay').click( function(){ // лoвим клик пo крестику или пoдлoжке
        $('#modal_form')
            .animate({opacity: 0, top: '45%'}, 200,  // плaвнo меняем прoзрaчнoсть нa 0 и oднoвременнo двигaем oкнo вверх
                function(){ // пoсле aнимaции
                    $(this).css('display', 'none'); // делaем ему display: none;
                    $('#overlay').fadeOut(400); // скрывaем пoдлoжку
                }
            );
    });


});



// document.addEventListener("DOMContentLoaded",
//   function (event) {
//
//     loadJSON("data/items.json", function(response) {
//       //var actual_JSON = JSON.parse(response);
//       actual_JSON = JSON.parse(response);
//       //console.log(actual_JSON);
//     });
//
//
//   }
// );


})();
