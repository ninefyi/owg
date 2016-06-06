<?php ob_start();

    require_once "config.php";

    $op = $_REQUEST['op'];

    if($op == "load_place"){
        load_place();
    }else if($op == "create_place"){
        create_place();
    }

    function create_place(){
        global $conn;
        $array = array();
        try{
            $place_name = $_GET['place_name'];
            $place_open = $_GET['place_open'];
            $place_description = $_GET['place_description'];
            $place_fee = $_GET['place_fee'];
            if(!empty($place_name)){
                $sql = "INSERT INTO place_service(place_name, place_open, place_description, place_fee, create_date) 
                        VALUES(?, ?, ?, ?, NOW())";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(1, $place_name, PDO::PARAM_STR, 255);
                $stmt->bindParam(2, $place_open, PDO::PARAM_STR);
                $stmt->bindParam(3, $place_description, PDO::PARAM_STR);
                $stmt->bindParam(4, $place_fee, PDO::PARAM_INT);
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

    function load_place(){
        global $conn;
        $array['records'] = array();
        try{
            $where = "";
            $sql = "SELECT *, DATE_FORMAT(create_date,'%d/%m/%Y') AS cdate FROM place_service WHERE 1=1 $where";
            //$array['error'] = $sql;
            $stmt = $conn->query($sql);
            $rs = $stmt->fetchAll();
            foreach($rs as $row){
                $array['records'][] = array(
                    "id" => $row['place_id'],
                    "name" => $row['place_name'],
                    "description" => $row['place_description'],
                    "fee" => $row['place_fee'],
                    "date" => $row['cdate'],
                    "open" => $row['place_open']
                );
            }
        }catch (Exception $ex){
            $array['error'] = $ex->getMessage();
        }
        echo json_encode($array);
    }


ob_end_flush();?>