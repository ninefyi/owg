<?php ob_start();

    require_once "config.php";

    $op = $_REQUEST['op'];

    if($op == "load_place"){
        load_place();
    }else if($op == "create_place"){
        create_place();
    }else if($op == "delete_place"){
        delete_place();
    }else if($op == "update_place") {
        update_place();
    }

    function delete_place(){
        global $conn;
        $array = array();
        try{
            $id = $_GET['place_id'];
            if(!empty($id)){
                $sql = "DELETE FROM place_service WHERE place_id=?";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(1, $id, PDO::PARAM_INT);
                $stmt->execute();
                $array['error'] = "";
            }else{
                $array['error'] = "Error delete_place";
            }

        }catch (Exception $ex){
            $array['error'] = $ex->getMessage();
        }
        echo json_encode($array);
    }

    function update_place(){
        global $conn;
        $array = array();
        try{
            $place_name = $_GET['place_name'];
            $place_name_eng = $_GET['place_name_eng'];
            $place_name_jp = $_GET['place_name_jp'];
            $place_open = $_GET['place_open'];
            $place_description = $_GET['place_description'];
            $place_description_eng = $_GET['place_description_eng'];
            $place_description_jp = $_GET['place_description_jp'];
            $place_fee = $_GET['place_fee'];
            $district_id = $_GET['district_id'];
            $place_id = $_GET['place_id'];
            if(!empty($place_name)){
                $sql = "UPDATE place_service SET 
                          place_name = ?
                          , place_name_eng = ?
                          , place_name_jp = ?
                          , place_open = ?
                          , place_description = ?
                          , place_description_eng = ?
                          , place_description_jp = ?
                          , place_fee = ?
                          , district_id = ?
                          , update_date = GETDATE()
                        WHERE place_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(1, $place_name, PDO::PARAM_STR, 255);
                $stmt->bindParam(2, $place_name_eng, PDO::PARAM_STR, 255);
                $stmt->bindParam(3, $place_name_jp, PDO::PARAM_STR, 255);
                $stmt->bindParam(4, $place_open, PDO::PARAM_STR);
                $stmt->bindParam(5, $place_description, PDO::PARAM_STR);
                $stmt->bindParam(6, $place_description_eng, PDO::PARAM_STR);
                $stmt->bindParam(7, $place_description_jp, PDO::PARAM_STR);
                $stmt->bindParam(8, $place_fee, PDO::PARAM_INT);
                $stmt->bindParam(9, $district_id, PDO::PARAM_INT);
                $stmt->bindParam(10, $place_id, PDO::PARAM_INT);
                $stmt->execute();
                $array['error'] = "";
            }else{
                $array['error'] = "Error create_place";
            }

        }catch (Exception $ex){
            $array['error'] = $ex->getMessage();
        }
        echo json_encode($array);
    }

    function create_place(){
        global $conn;
        $array = array();
        try{
            $place_name = $_GET['place_name'];
            $place_name_eng = $_GET['place_name_eng'];
            $place_name_jp = $_GET['place_name_jp'];
            $place_open = $_GET['place_open'];
            $place_description = $_GET['place_description'];
            $place_description_eng = $_GET['place_description_eng'];
            $place_description_jp = $_GET['place_description_jp'];
            $place_fee = $_GET['place_fee'];
            $district_id = $_GET['district_id'];
            if(!empty($place_name)){
                //var_dump($_GET);
                $sql = "INSERT INTO place_service(place_name, place_name_eng, place_name_jp, place_open, place_description, place_description_eng, place_description_jp, place_fee, district_id, create_date) 
                            VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
                //var_dump($sql);
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(1, $place_name, PDO::PARAM_STR, 255);
                $stmt->bindParam(2, $place_name_eng, PDO::PARAM_STR, 255);
                $stmt->bindParam(3, $place_name_jp, PDO::PARAM_STR, 255);
                $stmt->bindParam(4, $place_open, PDO::PARAM_STR);
                $stmt->bindParam(5, $place_description, PDO::PARAM_STR);
                $stmt->bindParam(6, $place_description_eng, PDO::PARAM_STR);
                $stmt->bindParam(7, $place_description_jp, PDO::PARAM_STR);
                $stmt->bindParam(8, $place_fee, PDO::PARAM_INT);
                $stmt->bindParam(9, $district_id, PDO::PARAM_INT);
                try{
                    $stmt->execute() or die(var_dump($stmt->errorInfo()));
                    $array['error'] = "";
                }catch(PDOException $ex){
                    $array['error'] = $ex->getMessage();
                }

            }else{
                $array['error'] = "Error create_place";
            }

        }catch (Exception $ex){
            $array['error'] = $ex->getMessage();
        }
        echo json_encode($array);
    }

    function load_place(){
        global $conn;
        $array['records'] = array();
        try{
            $where = "";
            $sql = "SELECT place_service.*
                      , DATE_FORMAT(create_date,'%d/%m/%Y') AS cdate
                      , district.district_name
                    FROM place_service
                      INNER JOIN district ON district.district_id = place_service.district_id
                    WHERE 1=1 $where";
            //$array['error'] = $sql;
            $stmt = $conn->query($sql);
            $rs = $stmt->fetchAll();
            foreach($rs as $row){
                $array['records'][] = array(
                    "id" => $row['place_id'],
                    "name" => $row['place_name'],
                    "name_eng" => $row['place_name_eng'],
                    "name_jp" => $row['place_name_jp'],
                    "description" => $row['place_description'],
                    "description_eng" => $row['place_description_eng'],
                    "description_jpF" => $row['place_description_jp'],
                    "fee" => $row['place_fee'],
                    "date" => $row['cdate'],
                    "open" => $row['place_open'],
                    "district_name" => $row['district_name'],
                    "district_id" => $row['district_id']
                );
            }
        }catch (Exception $ex){
            $array['error'] = $ex->getMessage();
        }
        echo json_encode($array);
    }


ob_end_flush();?>