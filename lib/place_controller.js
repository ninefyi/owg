var placeApp = angular.module('placeApp', ['ui.bootstrap']);
placeApp.controller('placeCtrl', function($scope, $http){

    $scope.formData = {};
    $scope.places = {};
    $scope.districts = {};
    $scope.editing = false;

    $scope.get_district_data = function(){
        $http.get("district_controller.php?op=load_district")
            .success(function(data, status, headers, config) {
                $scope.districts = data.records;
            })
            .error(function(data, status, headers, config) {
                alert(data);
            });
    };

    $scope.get_place_data = function(){
        $scope.get_district_data();
        $http.get("place_controller.php?op=load_place")
            .success(function(data, status, headers, config) {
                $scope.places = data.records;
            })
            .error(function(data, status, headers, config) {
                alert(data);
            });
    };

   $scope.delete_place = function(place) {
        var id = place.id;
        if (confirm('Are you sure to delete?')) {
            $http.get("place_controller.php?op=delete_place"
                    + "&place_id=" + id)
                .success(function(data, status, headers, config) {
                    $scope.get_place_data();
                })
                .error(function(data, status, headers, config) {
                    alert(data);
                });
        }
    };

    $scope.create_place = function(place){
        var place_name = place.name;
        var place_name_eng = place.name_eng;
        var place_name_jp = place.name_jp;
        var place_open = place.open;
        var place_description = place.description;
        var place_description_eng = place.description_eng;
        var place_description_jp = place.description_jp;
        var district_id = place.district_id;
        var place_fee = place.fee;
        $scope.formData = {};
        $http.post("place_controller.php?op=create_place"
            + "&place_name=" + place_name
            + "&place_name_eng=" + place_name_eng
            + "&place_name_jp=" + place_name_jp
            + "&place_open=" + place_open
            + "&place_description=" + place_description
            + "&place_description_eng=" + place_description_eng
            + "&place_description_jp=" + place_description_jp
            + "&district_id=" + district_id
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
        var place_name = place.name;
        var place_name_eng = place.name_eng;
        var place_name_jp = place.name_jp;
        var place_open = place.open;
        var place_description = place.description;
        var place_description_eng = place.description_eng;
        var place_description_jp = place.description_jp;
        var district_id = place.district_id;
        var place_fee = place.fee;
        var place_id = place.id;
        $scope.formData = {};
        $http.post("place_controller.php?op=update_place"
            + "&place_name=" + place_name
            + "&place_name_eng=" + place_name_eng
            + "&place_name_jp=" + place_name_jp
            + "&place_open=" + place_open
            + "&place_description=" + place_description
            + "&place_description_eng=" + place_description_eng
            + "&place_description_jp=" + place_description_jp
            + "&district_id=" + district_id
            + "&place_id=" + place_id
            + "&place_fee=" + place_fee)
            .success(function(data, status, headers, config) {
                $scope.get_place_data();
            })
            .error(function(data, status, headers, config) {
                alert(data);
            });
    };


});