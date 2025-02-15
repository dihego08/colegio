<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/simplexlsx/vendor/shuchkin/simplexlsx/src/SimpleXLSX.php';
$archivo = "tablas v4 preliminar.xlsx";
$mbd = new PDO('mysql:host=localhost; dbname=u132236064_almacenes', 'u132236064_almacenes', 'gbr>Lj^Ii2', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES  'UTF8'"));
//return $this->con;
echo "CONECTA";
if ($xlsx = SimpleXLSX::parse($archivo)) {

    $data_detalle = array();
    $u = 0;
    try {
        $mbd->beginTransaction(); // also helps speed up your inserts.

        foreach ($xlsx->rows() as $key) {
            echo $key[6] . "<br>";
            if ($u <= 1) {
            } else {
                $sede = $mbd->prepare("SELECT * FROM sedes WHERE codigo = :codigo");
                $sede->bindParam(":codigo", $key[2]);
                $sede->execute();
                $sede = $sede->fetch(PDO::FETCH_ASSOC);

                echo "SEDE " . $sede['id'] . "<br>";

                $emplazamiento = $mbd->prepare("SELECT * FROM emplazamiento WHERE codigo = :codigo AND id_sede = :id_sede");
                $emplazamiento->bindParam(":codigo", $key[3]);
                $emplazamiento->bindParam(":id_sede", $sede['id']);
                $emplazamiento->execute();
                $emplazamiento = $emplazamiento->fetch(PDO::FETCH_ASSOC);

                echo "EMPLAZAMIENTO " . $emplazamiento['id'] . "<br>";

                $usuario = $mbd->prepare("SELECT * FROM usuarios WHERE codigo = :codigo");
                $usuario->bindParam(":codigo", $key[16]);
                $usuario->execute();
                $usuario = $usuario->fetch(PDO::FETCH_ASSOC);

                $inventario = $mbd->prepare("INSERT INTO inventario(cuenta, id_sede, codigo_af, sap_padre, sap_comp, codigo_fisico, descripcion, marca, modelo, serie, medida, color, detalles, observaciones, otros, id_usuario, inventariador, id_clasificacion, id_estado, usuario_creacion, cod_inventario, id_emplazamiento, cantidad, unidad) VALUES (:cuenta, :id_sede, :codigo_af, :sap_padre, :sap_comp, :codigo_fisico, :descripcion, :marca, :modelo, :serie, :medida, :color, :detalles, :observaciones, :otros, :id_usuario, :inventariador, :id_clasificacion, :id_estado, :usuario_creacion, null, :id_emplazamiento, :cantidad, :unidad)");
                $id_clasificacion = null;
                $id_usuario = 1;
                $inventario->bindParam(":cuenta", $key[1]);
                $inventario->bindParam(":id_sede", $sede['id']);
                $inventario->bindParam(":codigo_af", $key[4]);
                $inventario->bindParam(":sap_padre", $id_clasificacion);
                $inventario->bindParam(":sap_comp", $id_clasificacion);
                $inventario->bindParam(":codigo_fisico", $key[5]);
                $inventario->bindParam(":descripcion", $key[6]);
                $inventario->bindParam(":marca", $key[9]);
                $inventario->bindParam(":modelo", $key[10]);
                $inventario->bindParam(":serie", $key[11]);
                $inventario->bindParam(":medida", $key[12]);
                $inventario->bindParam(":color", $key[13]);
                $inventario->bindParam(":detalles", $key[14]);
                $inventario->bindParam(":observaciones", $key[15]);
                $inventario->bindParam(":otros", $key[16]);
                $inventario->bindParam(":id_usuario", $usuario['id']);
                $inventario->bindParam(":inventariador", $id_usuario);
                $inventario->bindParam(":id_clasificacion", $id_clasificacion);
                $inventario->bindParam(":id_estado", $id_clasificacion);
                $inventario->bindParam(":usuario_creacion", $id_usuario);
                //$inventario->bindParam(":cod_inventario", $key[20]);
                $inventario->bindParam(":id_emplazamiento", $emplazamiento['id']);
                $inventario->bindParam(":cantidad", $key[7]);
                $inventario->bindParam(":unidad", $key[8]);
                $inventario->execute();
            }
            $u++;
        }
        $mbd->commit();
        $result = array(
            'Result' => 'OK'
        );
        echo json_encode($result);
    } catch (Exception $e) {
        $mbd->rollBack();
        $result = array(
            'Result' => 'ERROR',
            'Message' => $e->getMessage()
        );
        echo json_encode($result);
    }
} else {
    echo SimpleXLSX::parseError();
}
