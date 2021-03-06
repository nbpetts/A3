<!doctype html>
<html>

<head>
  <meta charset="UTF-8">
  <title>Hardware Checkout App</title>
  <meta name="author" content="Nathan Petts">
  <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />
  <link rel="stylesheet" href="css/base.css" />
  <link rel="stylesheet" href="css/layout.css" />
  <link rel="stylesheet" href="css/skeleton.css" />
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
  <script src="js/underscore/underscore.js"></script>
  <script src="js/backbone/backbone.js"></script>
  <script src="js/backbone.collectionView/backbone.collectionView.min.js"></script>

</head>

<body>
  <div id="pageWrapper" class="container">
    <h1 class="sixteen columns">Hardware Checkout</h1>
    <div id="tabs" class="sixteen columns container">
      <ul>
        <li>
          <a href="#checkedOut" class="">Checked Out</a>
        </li>
        <li>
          <a href="#checkedIn" class=" ">Checked In</a>
        </li>
        <li>
          <a href="#people" class=" ">People</a>
        </li>
        <li>
          <a href="#operations" class=" ">Add or Remove People or Equipment</a>
        </li>
      </ul>
      <div id="checkedOut">
        <ul id="checkedOutList">

        </ul>
      </div>
      <div id="checkedIn">
        <ul id="checkedInList" class="clearfix ten columns">

        </ul>
        <form method="post" action="php/????.php" id="personCheckingOut" class="five columns hidden">
          <label for="checkingOutTo">Who is checking this out?</label>
          <select name="checkingOutTo" id="checkingOutTo" required>
            <option value="" selected>Select a Person</option>
          </select>
          <label for="dateCheckingOut">Date the equipment is going out:</label>
          <input type="date" name="dateCheckingOut" id="dateCheckingOut" required>
          <label for="dateCheckingIn">Date the equipment is coming back:</label>
          <input type="date" name="dateCheckingIn" id="dateCheckingIn" required>

          <input type="submit" name="button" id="checkOutButton" value="Submit">
        </form>
      </div>
      <div id="people">
        <ul id="peopleList">

        </ul>
      </div>
      <div id="operations">
        <form method="post" action="php/????.php" id="addEquipment" class="seven columns">
          <h4>Add Equipment</h4>
          <p>
            <label for="equipName">Name of Equipment:</label>
            <input type="text" name="equipName" id="equipName">
            <label for="equipName">Type of Equipment:</label>
            <input type="text" name="equipType" id="equipType">
            <label for="checkedInOut">This is being checked out right now:</label>
            <input type="checkbox" name="checkedInOut" id="checkedInOut">
            <label for="checkedOutTo">Checked Out to:</label>
            <select name="checkedOutTo" id="checkedOutTo">
              <option value="">Select a Person</option>
            </select>
            <label for="dateOut">Date the equipment is going out:</label>
            <input type="date" name="dateOut" id="dateOut">
            <label for="dateIn">Date the equipment is coming back:</label>
            <input type="date" name="dateIn" id="dateIn">
            <input type="submit" name="button" id="equipButton" value="Submit">
          </p>
        </form>
        <form method="post" action="php/getEquipAndPeople.php" id="addPerson" class="seven columns">
          <h4>Add People</h4>
          <p>
            <label for="personName">Name of Person:</label>
            <input type="text" name="personName" id="personName">
            <label for="lps">Person's LPS:</label>
            <input type="text" name="lps" id="lps">
            <!--<label for="checkingOut">They are checking something out right now:</label>
            <input type="checkbox" name="checkingOut" id="checkingOut">
            <label for="equipCheckedOut">Equipment they are checking out:</label>
            <select name="equipCheckedOut" id="equipCheckedOut">
              <option value="">Select a piece of equipment</option>
            </select>
            <label for="dateOutPeople">Date the equipment is going out:</label>
            <input type="date" name="dateOutPeople" id="dateOutPeople">
            <label for="dateInPeople">Date the equipment is coming back:</label>
            <input type="date" name="dateInPeople" id="dateInPeople">-->
            <input type="submit" name="button" id="personButton" value="Submit">
          </p>
        </form>
        <div id="innerTabs" class="fifteen columns container">
          <ul>
            <li>
              <a href="#equipRemove">Remove Equipment</a>
            </li>
            <li>
              <a href="#peopleRemove">Remove People</a>
            </li>
          </ul>
          <div id="equipRemove">
            <ul id="equipRemoveList"></ul>
          </div>
          <div id="peopleRemove">
            <ul id="peopleRemoveList"></ul>
          </div>
        </div>
      </div>
    </div>
    <footer class="sixteen columns">&copy; 2014 Nathan Petts</footer>
  </div>
  <script>
    // init code for jqueryUI
    $("#tabs").tabs();
    $("#innerTabs").tabs();

     // shorthand document.ready
    $(function() {

      var Equipment = Backbone.Model.extend({
        urlRoot: "/a2PersistenceJSONtoMongo/equipments"
      });

      var EquipmentList = Backbone.Collection.extend({
        model: Equipment,
        url: "/a2PersistenceJSONtoMongo/equipments"
      });

      var People = Backbone.Model.extend({
        urlRoot: "/a2PersistenceJSONtoMongo/peoples"
      });

      var PeopleList = Backbone.Collection.extend({
        model: People,
        url: "/a2PersistenceJSONtoMongo/peoples"
      });

      /*var EquipmentOptionView = Backbone.View.extend({
        tagName: "option",
        render: function() {
          this.$el.html(this.model.get("name"));
          this.$el.attr("id", this.model.cid);
          this.$el.attr("value", this.model.name);
          $("#equipCheckedOut").append(this.$el);

        },

        initialize: function() {
          this.render();
          this.model.bind("destroy", this.remove, this);
        }
      });
*/
      var EquipmentCheckedInView = Backbone.View.extend({
        tagName: "li",
        template: _.template($("#checkOutItemTemplate").html()),
        render: function() {
          this.$el.html(this.template(this.model.toJSON()));
          this.$el.attr("id", this.model.cid);
          $("#checkedInList").append(this.$el);
          

        },
        events: {
          "click button.checkOut": "checkOut"
        },
        initialize: function() {
          this.render();
          this.model.bind("destroy", this.remove, this);
        },
        checkOut: function(){
          $("#personCheckingOut").undelegate();
          var equipment = equipments.get(this.model.cid),
              equipmentToAddArray = equipment.get("name"),
              view = this;
          
          $(".selected").removeClass("selected");
          $("#personCheckingOut").removeClass("hidden").addClass("selected");
          $(this.$el).addClass("selected");
          $("#personCheckingOut").on("click", "input#checkOutButton", function(event){
             event.preventDefault();
          var personCheckingOut = $("#checkingOutTo").val(),
            checkingOutDate = $("#dateCheckingOut").val(),
            checkingInDate = $("#dateCheckingIn").val();
           
         var personArray = peoples.where({name: personCheckingOut}),
             person = personArray[0],
             personsEquipArray = person.get("equipment"); 
          
            
            personsEquipArray.push(equipmentToAddArray);
            
            equipment.save({"checkedOut": true, "checkedOutTo": personCheckingOut, "checkedOutStart": checkingOutDate, "checkedOutEnd" : checkingInDate});
            person.save({"equipment" : personsEquipArray});
            view.remove();
            if (equipment.get("checkedOut")){
          new EquipmentCheckedOutView({model: equipment});
        }
        else{
          new EquipmentCheckedInView ({model: equipment});
        }
            var personCid = person.cid;
            $("li#"+personCid).remove();
            new RemovePersonView({model:person});
            new PersonView ({model:person});
          $("#personCheckingOut").addClass("hidden");  
          });
          
        
        }// end checkOut

        
      });
      
       var EquipmentCheckedOutView = Backbone.View.extend({
        tagName: "li",
        template: _.template($("#checkInItemTemplate").html()),
         events: {
          "click button.checkIn": "checkIn"
        },
        checkIn : function(){
          var equipment = equipments.get(this.model.cid),
              equipmentName = equipment.get("name"),
              personName = equipment.get("checkedOutTo"),
              personArray = peoples.where({name:personName}),
              person = personArray[0],
              personEquipArray = person.get("equipment"),
              index = personEquipArray.indexOf(equipmentName);
            if (index !== -1){
              personEquipArray.splice(index, 1);
            }
              
          equipment.save({"checkedOut":false, "checkedOutTo": "", "checkedOutStart": "", "checkedOutEnd" : ""});
          person.save({equipment:personEquipArray});
          this.remove();
          if (equipment.get("checkedOut")){
          new EquipmentCheckedOutView({model: equipment});
        }
        else{
          new EquipmentCheckedInView ({model: equipment});
        }
          var personCid = person.cid;
            $("li#"+personCid).remove();
          new RemovePersonView({model:person});
          new PersonView ({model:person});
        },
         
        render: function() {
          this.$el.html(this.template(this.model.toJSON()));
          this.$el.attr("id", this.model.cid);
          $("#checkedOutList").append(this.$el);
          
          

        },

        initialize: function() {
          this.render();
          this.model.bind("destroy", this.remove, this);
        }
      });


      var RemoveEquipmentView = Backbone.View.extend({
        tagName: "li",
        template: _.template($("#removeItemTemplate").html()),
        events: {
          "click button.removeEquipmentButton": "removeEquipment"
        },
         // This method removes equipment from the list.
        render: function() {
          this.$el.html(this.template(this.model.toJSON()));
          this.$el.attr("id", this.model.cid);
          $("#equipRemoveList").append(this.$el);

        },
        // This method removes a person from the list of people. 
        removeEquipment: function() {
          var equipment = equipments.get(this.model.cid);
          equipments.remove(equipment);
          equipment.destroy({
            error: function() {
              console.log("Destroy failed");
            }
          });
        },
        initialize: function() {
          this.render();
          this.model.bind("destroy", this.remove, this);
        }
      });

      var PersonOptionView = Backbone.View.extend({
        tagName: "option",
        render: function() {
          this.$el.html(this.model.get("name"));
          this.$el.attr("id", this.model.cid);
          this.$el.attr("value", this.model.name);
          $("#checkingOutTo, #checkedOutTo").append(this.$el);

        },
        
        initialize: function() {
          this.render();
          this.model.bind("destroy", this.remove, this);
        }
      });

      var PersonView = Backbone.View.extend({
        tagName: "li",
        template: _.template($("#personTemplate").html()),
        events: {
          "click button.checkInPerson": "checkIn"
        },
        checkIn : function(){
          var person = peoples.get(this.model.cid),
              equipmentNameArray = person.get("equipment");
          var equipmentArray =[];
              $.each(equipmentNameArray, function(index, equipmentName){
                equipmentArray.push(equipments.where({"name": equipmentName}));
              });
          var mergedEquipmentArray = [];
          mergedEquipmentArray = mergedEquipmentArray.concat.apply(mergedEquipmentArray, equipmentArray);
            $.each(mergedEquipmentArray, function(index, equipment){
              equipment.save({"checkedOut":false, "checkedOutTo": "", "checkedOutStart": "", "checkedOutEnd": ""});
              
                $("li#"+equipment.cid).remove();
              new RemoveEquipmentView({model: equipment});
                      if (equipment.get("checkedOut")){
          new EquipmentCheckedOutView({model: equipment});
        }
        else{
          new EquipmentCheckedInView ({model: equipment});
        }
            });
          person.save({"equipment":[]});
          $("li#"+person.cid).remove();
          new RemovePersonView ({model:person});
          new PersonView({model:person});     
          
        },
        render: function() {
          this.$el.html(this.template(this.model.toJSON()));
          this.$el.attr("id", this.model.cid);
          $("#peopleList").append(this.$el);

        },

        initialize: function() {
          this.render();
          this.model.bind("destroy", this.remove, this);
        }
      });

      var RemovePersonView = Backbone.View.extend({

        tagName: "li",
        template: _.template($("#removePersonTemplate").html()),
        events: {
          "click button.removePersonButton": "removePerson",
          "click button.checkInPerson": "checkIn"
        },
        checkIn : function(){
          var person = peoples.get(this.model.cid),
              equipmentNameArray = person.get("equipment");
          var equipmentArray =[];
              $.each(equipmentNameArray, function(index, equipmentName){
                equipmentArray.push(equipments.where({"name": equipmentName}));
              });
          var mergedEquipmentArray = [];
          mergedEquipmentArray = mergedEquipmentArray.concat.apply(mergedEquipmentArray, equipmentArray);
            $.each(mergedEquipmentArray, function(index, equipment){
              equipment.save({"checkedOut":false, "checkedOutTo": "", "checkedOutStart": "", "checkedOutEnd": ""});
              
                $("li#"+equipment.cid).remove();
              new RemoveEquipmentView({model: equipment});
                      if (equipment.get("checkedOut")){
          new EquipmentCheckedOutView({model: equipment});
        }
        else{
          new EquipmentCheckedInView ({model: equipment});
        }
            });
          person.save({"equipment":[]});
          $("li#"+person.cid).remove();
          new RemovePersonView ({model:person});
          new PersonView({model:person});     
          
        },
       
        // This method removes a person from the list of people. 
        removePerson: function() {
          this.checkIn;
          var person = peoples.get(this.model.cid);
          peoples.remove(person);
          person.destroy({
            error: function() {
              console.log("Destroy failed");
            }
          });
        },
        render: function() {
          this.$el.html(this.template(this.model.toJSON()));
          this.$el.attr("id", this.model.cid);
          $("#peopleRemove").append(this.$el);

        },
        initialize: function() {
          this.render();
          this.model.bind("destroy", this.remove, this);
        }
      });
      
      
      // This function adds a person to the list of people. .
      function addPerson(name, lps) {
        var person = new People({
          "name": name,
          "lps": lps,
          "equipment": []
        });
        peoples.add(person);
        person.save(null, {
          success: function(person, response, options) {
            person.id = person.attributes._id.$id;
            new PersonView({
              model: person
            });
            new RemovePersonView({
              model: person
            });
             new PersonOptionView({
          model: person
          });
          }
        }, {
          error: function(person, response, options) {
            alert("There is already a person with that name in the system.");
          }
        });
      }
      // end addPerson

      // This function adds equipment to the list. 
      function addEquipment(name, type, checkedOut, checkedOutTo, checkedOutStart, checkedOutEnd) {
        var equipment = new Equipment({
          "name": name,
          "type": type,
          "checkedOut": checkedOut,
          "checkedOutTo": checkedOutTo,
          "checkedOutStart": checkedOutStart,
          "checkedOutEnd": checkedOutEnd,
        });
        equipments.add(equipment);
        equipment.save(null, {
          success: function(equipment, response, options) {
            equipment.id = equipment.attributes._id.$id;
            /*new EquipmentOptionView({
              model: equipment
            });*/
            new RemoveEquipmentView ({
              model: equipment
            });
            if (equipment.get("checkedOut")){
          new EquipmentCheckedOutView({model: equipment});
        }
        else{
        new EquipmentCheckedInView ({model: equipment});
        }
            
          }
        });
        if (checkedOut){
          var personArray = peoples.where({"name": checkedOutTo}),
            person = personArray[0],
            personEquipArray = person.get("equipment");
        personEquipArray.push(name);
        person.save({"equipment": personEquipArray});
        $("li#"+person.cid).remove();
        new RemovePersonView ({model:person});
        new PersonView ({model:person});
                       }
        
      };// end addEquipment 

    
      // This handles the event of submitting on the add equipment form. It gathers name, type, and  contextually appropriate checkout data and calls addEquipment and checkOut with it. It resets the form when done. 
      $("#addEquipment").submit(function() {
        
        if ($("#checkedInOut").is(":checked")) {
          var name = $("#equipName").val(),
          type = $("#equipType").val(),
          checkedOut = true,
          checkedOutTo = $("#checkedOutTo").val(),
          dateOut = $("#dateOut").val(),
          dateIn = $("#dateIn").val();
          addEquipment(name, type, checkedOut, checkedOutTo, dateOut, dateIn);
        }
        else{
          var name = $("#equipName").val(),
          type = $("#equipType").val(),
          checkedOut = false,
          checkedOutTo = "",
          dateOut = "",
          dateIn = "";
          addEquipment(name, type, checkedOut, checkedOutTo, dateOut, dateIn);
        }
                
        $("#addEquipment")[0].reset();
        return false;

      }); // end submit

      // This handles the event of submitting on the add person form. It gathers name, lps, and contextually appropriate checkout data and calls addPerson and checkOut with it. It resets the form when done. 
      $("#addPerson").submit(function() {
          var name = $("#personName").val(),
          lps = $("#lps").val();
          addPerson(name, lps);
        $("#addPerson")[0].reset();
        return false;

      }); // end submit
          
     
     
      var peoples = new PeopleList();
      peoples.add( <?php include 'getPeople.php' ?> )
      peoples.models.forEach(function(person) {
        person.id = person.attributes._id.$id;
        person.attributes.id = person.attributes._id.$id;
        new PersonView({
          model: person
        });
        new RemovePersonView({
          model: person
        });
        new PersonOptionView({
          model: person
        });
      });
      var equipments = new EquipmentList();
      equipments.add( <?php include 'getEquipment.php' ?> )
      equipments.models.forEach(function(equipment) {
        equipment.id = equipment.attributes._id.$id;
        equipment.attributes.id = equipment.attributes._id.$id;
        new RemoveEquipmentView({
          model: equipment
        });
       /* new EquipmentOptionView({
          model: equipment
        });*/
        if (equipment.get("checkedOut")){
          new EquipmentCheckedOutView({model: equipment});
        }
        else{
          new EquipmentCheckedInView ({model: equipment});
        }
      });
      console.log
    }); // end ready
  </script>
  
  <script type="text/template" id="personTemplate">
    <span class = "personName"> <%= name %> </span>
    <span class="lps">  <%= lps %>  </span>
      <span class = "equipment"> <%= equipment %> </span>
    <button class="checkInPerson">Check In Everything this person has</button>
  </script>
  <script type="text/template" id="removePersonTemplate">
    <span class = "personName"> <%= name %> </span>
    <span class="lps">  <%= lps %>  </span>
      <span class = "equipment" > <%= equipment %> </span>
    <button class="checkInPerson">Check In Everything this person has</button>
      <button class = "removePersonButton"> Remove This Person from the List </button>
  </script>
  <script type="text/template" id="checkOutItemTemplate">
    <span class="name"><%= name %></span><span class="type"><%= type %></span><button class = "checkOut"> Check Out </button>
  </script>
  <script type="text/template" id="checkInItemTemplate">
    <span class="name"><%= name %></span><span class="type"><%= type %></span><span class="dateOut"><%= checkedOutStart %></span> <span class="dateIn"><%= checkedOutEnd %></span><span class="personName"><%= checkedOutTo %></span><button class = "checkIn"> Check In Item </button>
  </script>
  <script type="text/template" id="removeItemTemplate">
    <span class = "name"><%= name %></span><span class="type"><%= type %></span>
  <button class="removeEquipmentButton">Remove This Piece of Equipment from the List</button>
  </script>


  <!--<script type="text/template" id="personOptionTemplate">
    something with value / options
  </script>-->

</body>

</html>
<!--TODO
    add UI elements - confirmations, go look at huristics. look at using icons to show things, such as when someone has something checked out in the remove people tab     
    fix the tab width @ smaller media queries   
    check to see if I can figure out how to lint extra lines. 
    comment/validate/clean html
   <span class = "equipment"> <%= equipmentCheckedOut %> </span>
-->

