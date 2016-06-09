<?php ob_start();
    include_once("config.php");
?>
<!DOCTYPE html>
<html ng-app="placeApp" ng-controller="placeCtrl" lang="en">
<head>
    <meta charset="UTF-8">
    <link href="../lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../lib/web.css" rel="stylesheet">
    <title>Open World Travel</title>
    <script src="../lib/angular/angular.min.js"></script>
</head>
<body>
<form id="frm" name="frm">
    <div ng-include="'header.inc.php'"></div>
    <div id="place_data" class="container">
        <table border="1" class="table table-bordered table-responsive">
            <thead>
            <tr>
                <th>เมือง</th>
                <th>สถานที่</th>
                <th>สถานที่ (อังกฤษ)</th>
                <th>สถานที่ (ญี่ปุ่น)</th>
                <th>เวลาเปิด/ปิด</th>
                <th>ค่าเข้า เงินเยน (ถ้ามี)</th>
                <th>คำอธิบาย</th>
                <th>คำอธิบาย (อังกฤษ)</th>
                <th>คำอธิบาย (ญี่ปุ่น)</th>
                <th>การกระทำ</th>
            </tr>
            </thead>
            <tbody ng-init="get_place_data()">
            <tr>
                <td>
                    <select
                            ng-model="formData.district_id"
                            ng-options="obj.id as obj.name for obj in districts"></select>
                </td>
                <td>
                    <input type="text" size="20" ng-model="formData.name" />
                </td>
                <td>
                    <input type="text" size="20" ng-model="formData.name_eng" />
                </td>
                <td>
                    <input type="text" size="20" ng-model="formData.name_jp" />
                </td>
                <td>
                    <input type="text" size="10" ng-model="formData.open" />
                </td>
                <td>
                    <input type="text" size="10" ng-model="formData.fee" />
                </td>
                <td>
                    <textarea cols="30" rows="5" size="20" ng-model="formData.description"></textarea>
                </td>
                <td>
                    <textarea cols="30" rows="5" size="20" ng-model="formData.description_eng"></textarea>
                </td>
                <td>
                    <textarea cols="30" rows="5" size="20" ng-model="formData.description_jp"></textarea>
                </td>
                <td>
                    <button ng-click="create_place(formData)">Create</button>
                </td>
            </tr>
            <tr ng-repeat="data in places" ng-class-even="'evenRow'" ng-class-odd="'oddEven'">
                <td>
                    <span ng-hide="editMode">{{data.district_name}}</span>
                    <select
                        ng-show="editMode"
                        ng-model="data.district_id"
                        ng-options="obj.id as obj.name for obj in districts"></select>
                </td>
                <td>
                    <span ng-hide="editMode">{{data.name}}</span>
                    <input type="text" ng-show="editMode" size="30" ng-model="data.name" />
                </td>
                <td>
                    <span ng-hide="editMode">{{data.name_eng}}</span>
                    <input type="text" ng-show="editMode" size="30" ng-model="data.name_eng" />
                </td>
                <td>
                    <span ng-hide="editMode">{{data.name_jp}}</span>
                    <input type="text" ng-show="editMode" size="30" ng-model="data.name_jp" />
                </td>
                <td>
                    <span ng-hide="editMode">{{data.open}}</span>
                    <input type="text" ng-show="editMode" size="10" ng-model="data.open" />
                </td>
                <td>
                    <span ng-hide="editMode">{{data.fee}}</span>
                    <input type="text" ng-show="editMode" size="10" ng-model="data.fee" />
                </td>
                <td>
                    <span ng-hide="editMode">{{data.description}}</span>
                    <textarea cols="30" rows="5" ng-show="editMode" size="20" ng-model="data.description"></textarea>
                </td>
                <td>
                    <span ng-hide="editMode">{{data.description_eng}}</span>
                    <textarea cols="30" rows="5" ng-show="editMode" size="20" ng-model="data.description_eng"></textarea>
                </td>
                <td>
                    <span ng-hide="editMode">{{data.description_jp}}</span>
                    <textarea cols="30" rows="5" ng-show="editMode" size="20" ng-model="data.description_jp"></textarea>
                </td>
                <td>
                    <button ng-hide="editMode" ng-click="editMode=true;edit_place(data)">แก้ไข</button>
                    <button ng-show="editMode" ng-click="editMode=false;update_place(data)">บันทึก</button> |
                    <button ng-click="delete_place(data)">ลบ</button>
                </td>
            </tr>
            <tr ng-if="places.length == 0"><th colspan="10" style="text-align: center;background-color: #c0c0c0;">ไม่พบข้อมูล</th></tr>
            </tbody>
        </table>
    </div>
</form>
</body>
<script src="../lib/place_controller.js"></script>
<script src="../lib/bootstrap/js/ui-bootstrap-tpls-0.13.0.min.js"></script>
</html>
<?php ob_end_flush();?>
