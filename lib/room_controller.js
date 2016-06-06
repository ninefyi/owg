var roomApp = angular.module('roomApp', ['ui.bootstrap']);
roomApp.controller('roomCtrl', function($scope, $http){
    $scope.rooms = {};
    $scope.editing = false;
    $scope.loader = {
        loading: false
    };
    $scope.get_room = function(){
        $scope.loader.loading = true;
        $http.get("room_action.php?op=load_room")
            .success(function(data, status, headers, config) {
                $scope.rooms = data.records;
                $scope.loader.loading = false;
            })
            .error(function(data, status, headers, config) {
                alert(data);
            });
    };

    $scope.update_room = function(room){
        $scope.loader.loading = true;
        var room_no = room.no;
        var room_password = room.password;
        $http.get("room_action.php?op=update_room&room_no=" + room_no + "&room_password=" + room_password)
            .success(function(data, status, headers, config) {
                $scope.get_room();
            })
            .error(function(data, status, headers, config) {
                alert(data);
            });
    };

    $scope.edit_room = function(index){
        $scope.editing = $scope.rooms.indexOf(index);

    };

    $scope.delete_room = function(room) {
        if (confirm('Are you sure to delete?')) {
            var room_no = room.no;
            $http.get("room_action.php?op=delete_room&room_no=" + room_no)
                .success(function(data, status, headers, config) {
                    $scope.get_room();
                })
                .error(function(data, status, headers, config) {
                    alert(data);
                });
        }
    };

    $scope.create_room = function(room){
        $scope.loader.loading = true;
        var room_no = room.no;
        var room_password = room.password;
        $http.get("room_action.php?op=create_room&room_no=" + room_no + "&room_password=" + room_password)
            .success(function(data, status, headers, config) {
                $scope.get_room();
            })
            .error(function(data, status, headers, config) {
                alert(data);
            });
    };

});