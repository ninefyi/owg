var placeApp = angular.module('placeApp', ['ui.bootstrap']);
placeApp.controller('placeCtrl', function($scope, $http){

    $scope.formData = {};
    $scope.places = {};
    $scope.editing = false;

    $scope.get_place_data = function(){
        $http.get("place_controller.php?op=load_place")
            .success(function(data, status, headers, config) {
                $scope.places = data.records;
            })
            .error(function(data, status, headers, config) {
                alert(data);
            });
    };

   $scope.delete_place = function() {
        if (confirm('Are you sure to delete?')) {
        }
    };

    $scope.create_place = function(place){
        var place_name = place.name;
        var place_open = place.open;
        var place_description = place.description;
        var place_fee = place.fee;
        $http.post("place_controller.php?op=create_place"
            + "&place_name=" + place_name
            + "&place_open=" + place_open
            + "&place_description=" + place_description
            + "&place_fee=" + place_fee)
            .success(function(data, status, headers, config) {
                $scope.get_place_data();
            })
            .error(function(data, status, headers, config) {
                alert(data);
            });
    }

    $scope.edit_place = function(index){
        $scope.editing = $scope.places.indexOf(index);
    };

    $scope.update_place_room = function(place){
        $http.post("place_controller.php?op=update_place")
            .success(function(data, status, headers, config) {
                $scope.places = data.records;
            })
            .error(function(data, status, headers, config) {
                alert(data);
            });
    };


});