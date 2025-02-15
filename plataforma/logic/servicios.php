<?php
session_start();
include("../../env/env.php");
if ($_GET['parAccion'] == "get_data") {
    $query = $mbd->prepare("SELECT c.carrera, a.area, u.id_aula FROM usuarios as u, carreras as c, areas as a WHERE u.id = :id_usuario AND u.id_carrera = c.id AND c.id_area = a.id");
    $query->bindParam(":id_usuario", $_SESSION['id']);
    $query->execute();

    $usuario = $query->fetch(PDO::FETCH_ASSOC);

    $aula = $mbd->prepare("SELECT * FROM aulas WHERE id = :id_aula");
    $aula->bindParam(":id_aula", $usuario['id_aula']);
    $aula->execute();

    $aula = $aula->fetch(PDO::FETCH_ASSOC);

    echo json_encode(
        array(
            "user_name" => $_SESSION['nombres'],
            "carrera" => $usuario['carrera'],
            "area" => $usuario['area'],
            "aula" => $aula['aula']
        )
    );
} elseif ($_GET['parAccion'] == "load_data_profesor") {
    $query = $mbd->prepare("SELECT * FROM profesores WHERE id = :id");
    $query->bindParam(":id", $_SESSION['id']);
    $query->execute();

    $data = $query->fetch(PDO::FETCH_ASSOC);

    unset($data['pass']);

    echo json_encode($data);
} elseif ($_GET['parAccion'] == "load_data") {
    $query = $mbd->prepare("SELECT * FROM usuarios WHERE id = :id");
    $query->bindParam(":id", $_SESSION['id']);
    $query->execute();

    $data = $query->fetch(PDO::FETCH_ASSOC);

    unset($data['pass']);

    echo json_encode($data);
} elseif ($_GET['parAccion'] == "update_profile_profesor") {
    try {
        $mbd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $mbd->beginTransaction();

        if (empty($_POST['pass']) || is_null($_POST['pass'])) {
            $query = $mbd->prepare("UPDATE profesores SET nombres = :nombres, usuario = :usuario, sobre_mi = :sobre_mi, profesion = :profesion, correo = :correo WHERE id = :id");
            $query->bindParam(":nombres", $_POST['nombres']);
            $query->bindParam(":usuario", $_POST['usuario']);
            $query->bindParam(":sobre_mi", $_POST['sobre_mi']);
            $query->bindParam(":profesion", $_POST['profesion']);
            $query->bindParam(":correo", $_POST['correo']);
            $query->bindParam(":id", $_SESSION['id']);
            $query->execute();
        } else {
            $query = $mbd->prepare("UPDATE profesores SET nombres = :nombres, usuario = :usuario, sobre_mi = :sobre_mi, profesion = :profesion, correo = :correo, pass = :pass WHERE id = :id");
            $query->bindParam(":nombres", $_POST['nombres']);
            $query->bindParam(":usuario", $_POST['usuario']);
            $query->bindParam(":sobre_mi", $_POST['sobre_mi']);
            $query->bindParam(":profesion", $_POST['profesion']);
            $query->bindParam(":correo", $_POST['correo']);
            $query->bindParam(":correo", md5($_POST['pass']));
            $query->bindParam(":id", $_SESSION['id']);
            $query->execute();
        }


        $mbd->commit();
        $result = array(
            'Result' => 'OK',
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
} elseif ($_GET['parAccion'] == "update_profile") {
    try {
        $mbd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $mbd->beginTransaction();


        if ($_FILES['file1']['size'] == 0 && $_FILES['file1']['error'] == 0) {
            if (empty($_POST['pass']) || is_null($_POST['pass'])) {
                $query = $mbd->prepare("UPDATE usuarios SET nombres = :nombres, apellidos = :apellidos, usuario = :usuario, sobre_mi = :sobre_mi, direccion = :direccion, correo = :correo, telefono = :telefono, id_carrera = :id_carrera WHERE id = :id");
                $query->bindParam(":nombres", $_POST['nombres']);
                $query->bindParam(":apellidos", $_POST['apellidos']);
                $query->bindParam(":usuario", $_POST['usuario']);
                $query->bindParam(":sobre_mi", $_POST['sobre_mi']);
                $query->bindParam(":direccion", $_POST['direccion']);
                $query->bindParam(":correo", $_POST['correo']);
                $query->bindParam(":telefono", $_POST['telefono']);
                $query->bindParam(":id_carrera", $_POST['id_carrera']);
                $query->bindParam(":id", $_SESSION['id']);
                $query->execute();
            } else {
                $query = $mbd->prepare("UPDATE usuarios SET nombres = :nombres, apellidos = :apellidos, usuario = :usuario, sobre_mi = :sobre_mi, direccion = :direccion, correo = :correo, pass = :pass, telefono = :telefono, id_carrera = :id_carrera WHERE id = :id");
                $query->bindParam(":nombres", $_POST['nombres']);
                $query->bindParam(":apellidos", $_POST['apellidos']);
                $query->bindParam(":usuario", $_POST['usuario']);
                $query->bindParam(":sobre_mi", $_POST['sobre_mi']);
                $query->bindParam(":direccion", $_POST['direccion']);
                $query->bindParam(":correo", $_POST['correo']);
                $query->bindParam(":pass", md5($_POST['pass']));
                $query->bindParam(":telefono", $_POST['telefono']);
                $query->bindParam(":id_carrera", $_POST['id_carrera']);
                $query->bindParam(":id", $_SESSION['id']);
                $query->execute();
            }
        } else {
            $fileName = $_FILES["file1"]["name"];
            $fileTmpLoc = $_FILES["file1"]["tmp_name"];
            $fileType = $_FILES["file1"]["type"];
            $fileSize = $_FILES["file1"]["size"];
            $fileErrorMsg = $_FILES["file1"]["error"];
            if (!$fileTmpLoc) {
                //exit();
            }
            if (move_uploaded_file($fileTmpLoc, $_SERVER['DOCUMENT_ROOT'] . "/intranet/system/controllers/uploads/$fileName")) {
                $_POST["foto"] = $fileName;
                if (empty($_POST['pass']) || is_null($_POST['pass'])) {
                    $query = $mbd->prepare("UPDATE usuarios SET nombres = :nombres, apellidos = :apellidos, usuario = :usuario, sobre_mi = :sobre_mi, direccion = :direccion, correo = :correo, telefono = :telefono, foto = :foto, id_carrera = :id_carrera WHERE id = :id");
                    $query->bindParam(":nombres", $_POST['nombres']);
                    $query->bindParam(":apellidos", $_POST['apellidos']);
                    $query->bindParam(":usuario", $_POST['usuario']);
                    $query->bindParam(":sobre_mi", $_POST['sobre_mi']);
                    $query->bindParam(":direccion", $_POST['direccion']);
                    $query->bindParam(":correo", $_POST['correo']);
                    $query->bindParam(":telefono", $_POST['telefono']);
                    $query->bindParam(":foto", $_POST['foto']);
                    $query->bindParam(":id_carrera", $_POST['id_carrera']);
                    $query->bindParam(":id", $_SESSION['id']);
                    $query->execute();
                } else {
                    $query = $mbd->prepare("UPDATE usuarios SET nombres = :nombres, apellidos = :apellidos, usuario = :usuario, sobre_mi = :sobre_mi, direccion = :direccion, correo = :correo, pass = :pass, telefono = :telefono, foto = :foto, id_carrera = :id_carrera WHERE id = :id");
                    $query->bindParam(":nombres", $_POST['nombres']);
                    $query->bindParam(":apellidos", $_POST['apellidos']);
                    $query->bindParam(":usuario", $_POST['usuario']);
                    $query->bindParam(":sobre_mi", $_POST['sobre_mi']);
                    $query->bindParam(":direccion", $_POST['direccion']);
                    $query->bindParam(":correo", $_POST['correo']);
                    $query->bindParam(":pass", md5($_POST['pass']));
                    $query->bindParam(":telefono", $_POST['telefono']);
                    $query->bindParam(":foto", $_POST['foto']);
                    $query->bindParam(":id_carrera", $_POST['id_carrera']);
                    $query->bindParam(":id", $_SESSION['id']);
                    $query->execute();
                }
            } else {
                if (empty($_POST['pass']) || is_null($_POST['pass'])) {
                    $query = $mbd->prepare("UPDATE usuarios SET nombres = :nombres, apellidos = :apellidos, usuario = :usuario, sobre_mi = :sobre_mi, direccion = :direccion, correo = :correo, telefono = :telefono, id_carrera = :id_carrera WHERE id = :id");
                    $query->bindParam(":nombres", $_POST['nombres']);
                    $query->bindParam(":apellidos", $_POST['apellidos']);
                    $query->bindParam(":usuario", $_POST['usuario']);
                    $query->bindParam(":sobre_mi", $_POST['sobre_mi']);
                    $query->bindParam(":direccion", $_POST['direccion']);
                    $query->bindParam(":correo", $_POST['correo']);
                    $query->bindParam(":telefono", $_POST['telefono']);
                    $query->bindParam(":id_carrera", $_POST['id_carrera']);
                    $query->bindParam(":id", $_SESSION['id']);
                    $query->execute();
                } else {
                    $query = $mbd->prepare("UPDATE usuarios SET nombres = :nombres, apellidos = :apellidos, usuario = :usuario, sobre_mi = :sobre_mi, direccion = :direccion, correo = :correo, pass = :pass, telefono = :telefono, id_carrera = :id_carrera WHERE id = :id");
                    $query->bindParam(":nombres", $_POST['nombres']);
                    $query->bindParam(":apellidos", $_POST['apellidos']);
                    $query->bindParam(":usuario", $_POST['usuario']);
                    $query->bindParam(":sobre_mi", $_POST['sobre_mi']);
                    $query->bindParam(":direccion", $_POST['direccion']);
                    $query->bindParam(":correo", $_POST['correo']);
                    $query->bindParam(":pass", md5($_POST['pass']));
                    $query->bindParam(":telefono", $_POST['telefono']);
                    $query->bindParam(":id_carrera", $_POST['id_carrera']);
                    $query->bindParam(":id", $_SESSION['id']);
                    $query->execute();
                }
            }
        }

        $mbd->commit();
        $result = array(
            'Result' => 'OK',
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
} elseif ($_GET['parAccion'] == "get_modules") {
    $query = $mbd->prepare("SELECT * FROM tbl_modulos");
    $query->execute();

    $values = array();

    while ($res = $query->fetch(PDO::FETCH_ASSOC)) {
        $values[] = $res;
    }

    echo json_encode($values);
} elseif ($_GET['parAccion'] == "module_detail") {
    $query = $mbd->prepare("SELECT * FROM tbl_temas WHERE id_modulo = :id ORDER BY orden ASC");
    $query->bindParam(":id", $_POST['id']);
    $query->execute();

    $temas = array();

    while ($res = $query->fetch(PDO::FETCH_ASSOC)) {
        $query_horario = $mbd->prepare("SELECT * FROM horarios_2 WHERE id_tema = :id_tema");
        $query_horario->bindParam(":id_tema", $res['id']);
        $query_horario->execute();

        $query_profesor = $mbd->prepare("SELECT * FROM profesores WHERE id = :id_profesor");
        $query_profesor->bindParam(":id_profesor", $res['id_profesor']);
        $query_profesor->execute();

        $profesor = $query_profesor->fetch(PDO::FETCH_ASSOC);

        $horario = array();
        while ($r = $query_horario->fetch(PDO::FETCH_ASSOC)) {
            $horario[] = $r;
        }

        $res['horario'] = $horario;
        $res['profesor'] = $profesor['nombres'];
        $temas[] = $res;
    }

    echo json_encode($temas);
} elseif ($_GET['parAccion'] == "theme_detail") {
    $query = $mbd->prepare("SELECT * FROM cursos WHERE id = :id");
    $query->bindParam(":id", $_POST['id']);
    $query->execute();

    $result = array();

    $query_videos = $mbd->prepare("SELECT * FROM videos WHERE id_curso = :id ORDER BY id DESC");
    $query_videos->bindParam(":id", $_POST['id']);
    $query_videos->execute();

    $videos = array();
    while ($res = $query_videos->fetch(PDO::FETCH_ASSOC)) {

        $query_material = $mbd->prepare("SELECT * FROM materiales WHERE id_video = :id_video");
        $query_material->bindParam(":id_video", $res['id']);
        $query_material->execute();

        $materiales = array();
        while ($r = $query_material->fetch(PDO::FETCH_ASSOC)) {
            $materiales[] = array(
                "material" => $r['material']
            );
        }
        if ($res['material_adicional'] == "" || is_null($res['material_adicional'])) {
        } else {
            $materiales[] = array(
                'material' => $res['material_adicional']
            );
        }
        $res['materiales'] = $materiales;
        $videos[] = $res;
    }

    $query_tareas = $mbd->prepare("SELECT * FROM tareas WHERE id_curso = :id ORDER BY id DESC");
    $query_tareas->bindParam(":id", $_POST['id']);
    $query_tareas->execute();

    $tareas = array();
    while ($res = $query_tareas->fetch(PDO::FETCH_ASSOC)) {
        $tareas[] = $res;
    }

    $query_horario = $mbd->prepare("SELECT * FROM horarios WHERE id_curso = :id_curso");
    $query_horario->bindParam(":id_curso", $_POST['id']);
    $query_horario->execute();

    $horarios = array();

    while ($res = $query_horario->fetch(PDO::FETCH_ASSOC)) {
        $horarios[] = $res;
    }

    $query_recursos = $mbd->prepare("SELECT * FROM recursos WHERE id_curso = :id ORDER BY id DESC");
    $query_recursos->bindParam(":id", $_POST['id']);
    $query_recursos->execute();

    $recursos = array();
    while ($res = $query_recursos->fetch(PDO::FETCH_ASSOC)) {
        //$recursos[] = $res;
        if (empty($res['archivo']) || is_null($res['archivo'])) {
            $res['tipo'] = 'Enlace Externo';
            $res['enlace'] = $res['enlace'];
            $res['nombre'] = $res['enlace'];
        } else {
            $res['tipo'] = 'Archivo';
            $res['enlace'] = '/recursos/' . $res['archivo'];
            $res['nombre'] = $res['archivo'];
        }
        $recursos[] = $res;
    }

    $result = $query->fetch(PDO::FETCH_ASSOC);
    $result['videos'] = $videos;
    $result['recursos'] = $recursos;
    $result['horarios'] = $horarios;
    $result['tareas'] = $tareas;

    echo json_encode($result);
} elseif ($_GET['parAccion'] == "get_asistencias") {

    $query_modulos = $mbd->prepare("SELECT * FROM tbl_modulos");
    $query_modulos->execute();
    $result = array();
    while ($res = $query_modulos->fetch(PDO::FETCH_ASSOC)) {
        //$modulos = 
        $query_temas = $mbd->prepare("SELECT * FROM tbl_temas WHERE id_modulo = :id_modulo");
        $query_temas->bindParam(":id_modulo", $res['id']);
        $query_temas->execute();
        $cant_clases = 0;
        $cant_asistencias = 0;

        while ($r = $query_temas->fetch(PDO::FETCH_ASSOC)) {
            $query_horario = $mbd->prepare("SELECT COUNT(*) as cant FROM horarios_2 WHERE id_tema = :id_tema");
            $query_horario->bindParam(":id_tema", $r['id']);
            $query_horario->execute();

            $horario = $query_horario->fetch(PDO::FETCH_ASSOC);

            $cant_clases += $horario['cant'];

            $query_asistencia = $mbd->prepare("SELECT COUNT(*) as cant FROM tbl_asistencias WHERE id_tema = :id_tema AND id_alumno = :id_alumno");
            $query_asistencia->bindParam(":id_tema", $r['id']);
            $query_asistencia->bindParam(":id_alumno", $_SESSION['id']);
            $query_asistencia->execute();

            $asistencia = $query_asistencia->fetch(PDO::FETCH_ASSOC);

            $cant_asistencias += $asistencia['cant'];
        }

        $result[] = array(
            'modulo' => $res['modulo'],
            'clases' => $cant_clases,
            'asistencias' => $cant_asistencias
        );
    }
    echo json_encode($result);
} elseif ($_GET['parAccion'] == "get_ahora") {
    try {


        $mbd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $mbd->beginTransaction();

        $query_grupo = $mbd->prepare("SELECT id_carrera, id_universidad, id_ciclo, id_grupo FROM usuarios WHERE id = :id");
        $query_grupo->bindParam(":id", $_SESSION['id']);
        $query_grupo->execute();

        $data_grupo = $query_grupo->fetch(PDO::FETCH_ASSOC);

        //print_r($data_grupo);

        $hoy = date("Y-m-d");

        $dia_hoy = date("w");

        $query = $mbd->prepare("SELECT * FROM horarios WHERE dia = :dia_hoy ORDER BY inicio");
        $query->bindParam(":dia_hoy", $dia_hoy);
        $query->execute();

        while ($res = $query->fetch(PDO::FETCH_ASSOC)) {
            $fecha_hora = date("Y-m-d") . " " . $res['inicio'] . ":00";

            $date1 = new DateTime($fecha_hora);
            $date2 = new DateTime("now");
            $diff = $date1->diff($date2);

            if ($diff->h == 0) {
                $res['p'] = 'Y';
            } else {
                $res['p'] = 'N';
            }

            $res['horario'] = $res['inicio'] . " - " . $res['fin'];

            $query_curso = $mbd->prepare("SELECT * FROM cursos WHERE id = :id_curso AND id_grupo = :id_grupo");
            $query_curso->bindParam(":id_curso", $res['id_curso']);
            $query_curso->bindParam(":id_grupo", $data_grupo['id_grupo']);
            $query_curso->execute();

            //echo $data_grupo['id'] . "<br>";
            $curso = $query_curso->fetch(PDO::FETCH_ASSOC);
            //$count = $query_curso->fetchColumn();
            //echo $count . "<br>";

            if (is_null($curso['curso']) || $curso['curso'] == null) {
            } else {


                //print_r($curso);

                $query_profesor = $mbd->prepare("SELECT nombres FROM profesores WHERE id = :id_profesor");
                $query_profesor->bindParam(":id_profesor", $curso['id_profesor']);
                $query_profesor->execute();

                $profesor = $query_profesor->fetch(PDO::FETCH_ASSOC);

                $res['curso'] = $curso['curso'];
                $res['profesor'] = $profesor['nombres'];

                $values[] = $res;
            }
        }

        $mbd->commit();
        echo json_encode($values);
    } catch (Exception $e) {
        $mbd->rollBack();
        $result = array(
            'Result' => 'ERROR',
            'Message' => $e->getMessage()
        );
        echo json_encode($result);
    }
} elseif ($_GET['parAccion'] == "marcar_asistencia") {
    $fecha = date("Y-m-d");
    $hora = date("H:i");

    try {
        $mbd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $mbd->beginTransaction();

        $query_cuenta = $mbd->prepare("SELECT COUNT(*) as cant FROM tbl_asistencias WHERE id_alumno = :id_alumno AND id_curso = :id_curso AND fecha = :fecha");
        $query_cuenta->bindParam(":id_alumno", $_SESSION['id']);
        $query_cuenta->bindParam(":id_curso", $_POST['id_curso']);
        $query_cuenta->bindParam(":fecha", $fecha);
        $query_cuenta->execute();

        $cant = $query_cuenta->fetch(PDO::FETCH_ASSOC);

        if ($cant['cant'] == 0) {
            $query_i = $mbd->prepare("INSERT INTO tbl_asistencias(id_curso, id_alumno, fecha, entrada) VALUES(:id_curso, :id_alumno, :fecha, :entrada);");
            $query_i->bindParam(":id_alumno", $_SESSION['id']);
            $query_i->bindParam(":id_curso", $_POST['id_curso']);
            $query_i->bindParam(":fecha", $fecha);
            $query_i->bindParam(":entrada", $hora);
            $query_i->execute();
        } else {
        }

        /*$query = $mbd->prepare("DELETE FROM tbl_asistencias WHERE id_alumno = :id_alumno AND id_curso = :id_curso AND fecha = :fecha");
        $query->bindParam(":id_alumno", $_SESSION['id']);
        $query->bindParam(":id_curso", $_POST['id_curso']);
        $query->bindParam(":fecha", $fecha);
        $query->execute();*/



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
} elseif ($_GET['parAccion'] == "get_info_tema") {
    $query = $mbd->prepare("SELECT * FROM cursos WHERE id = :id");
    $query->bindParam(":id", $_POST['id_curso']);
    $query->execute();

    $values = $query->fetch(PDO::FETCH_ASSOC);

    $sql_transmision = $mbd->prepare("SELECT * FROM transmisiones WHERE id_curso = :id_curso ORDER BY id DESC");
    $sql_transmision->bindParam(":id_curso", $_POST['id_curso']);
    $sql_transmision->execute();

    $transmision = $sql_transmision->fetch(PDO::FETCH_ASSOC);


    $sql_sala = $mbd->prepare("SELECT * FROM salas WHERE id_curso = :id_curso ORDER BY id DESC");
    $sql_sala->bindParam(":id_curso", $_POST['id_curso']);
    $sql_sala->execute();

    $sala = $sql_sala->fetch(PDO::FETCH_ASSOC);

    $values['transmision'] = $transmision['enlace'];
    $values['sala'] = $sala['sala'];
    $values['externo'] = $sala['externo'];

    echo json_encode($values);
} elseif ($_GET['parAccion'] == "marcar_salida") {
    $fecha = date("Y-m-d");
    $hora = date("H:i");

    try {
        $mbd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $mbd->beginTransaction();

        $query_i = $mbd->prepare("UPDATE tbl_asistencias SET salida = :salida WHERE id_curso = :id_curso AND id_alumno = :id_alumno AND fecha = :fecha;");
        $query_i->bindParam(":id_alumno", $_SESSION['id']);
        $query_i->bindParam(":id_curso", $_POST['id_curso']);
        $query_i->bindParam(":fecha", $fecha);
        $query_i->bindParam(":salida", $hora);
        $query_i->execute();

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
} elseif ($_GET['parAccion'] == "mis_cursos_profesor") {
    //$query = $mbd->prepare("SELECT m.modulo, t.* FROM tbl_modulos as m, tbl_temas as t WHERE m.id = t.id_modulo AND t.id_profesor = :id_profesor");
    $query = $mbd->prepare("SELECT c.ciclo, g.grupo, cu.* FROM ciclos as c, grupos as g, cursos as cu WHERE cu.id_grupo = g.id AND g.id_ciclo = c.id AND cu.id_profesor = :id_profesor");
    $query->bindParam(":id_profesor", $_SESSION['id']);
    $query->execute();

    $result = array();

    while ($res = $query->fetch(PDO::FETCH_ASSOC)) {
        $result[] = $res;
    }

    echo json_encode($result);
} elseif ($_GET['parAccion'] == "mis_cursos_profesor_hoy") {
    //$query = $mbd->prepare("SELECT m.modulo, t.* FROM tbl_modulos as m, tbl_temas as t WHERE m.id = t.id_modulo AND t.id_profesor = :id_profesor");
    $query = $mbd->prepare("SELECT c.ciclo, g.grupo, cu.* FROM ciclos as c, grupos as g, cursos as cu WHERE cu.id_grupo = g.id AND g.id_ciclo = c.id AND cu.id_profesor = :id_profesor");
    $query->bindParam(":id_profesor", $_SESSION['id']);
    $query->execute();

    $result = array();
    $hoy = date("Y-m-d");
    $dia_hoy = date("w");

    while ($res = $query->fetch(PDO::FETCH_ASSOC)) {
        $query_horario = $mbd->prepare("SELECT * FROM horarios WHERE dia = :dia_hoy AND id_curso = :id_curso");
        $query_horario->bindParam(":dia_hoy", $dia_hoy);
        $query_horario->bindParam(":id_curso", $res['id']);
        $query_horario->execute();

        $horario = $query_horario->fetch(PDO::FETCH_ASSOC);


        $query_sala = $mbd->prepare("SELECT * FROM salas WHERE DATE(fecha) = :dia_hoy AND id_curso = :id_curso");
        $query_sala->bindParam(":dia_hoy", $hoy);
        $query_sala->bindParam(":id_curso", $res['id']);
        $query_sala->execute();

        $sala = $query_sala->fetch(PDO::FETCH_ASSOC);

        if (empty($horario) || count($horario) == 0) {
        } else {
            if (empty($sala) || count($sala) == 0) {
                $res['sala'] = "sin_sala";
            } else {
                $res['sala'] = $sala['sala'];
            }
            $res['horario'] = $horario;
            $result[] = $res;
        }
    }

    echo json_encode($result);
} elseif ($_GET['parAccion'] == "ver_entregas_tareas") {
    $query = $mbd->prepare("SELECT CONCAT(a.nombres, ' ', a.apellidos) as alumno, e.* FROM usuarios as a, entrega_tarea as e WHERE e.id_tarea = :id_tarea AND e.id_alumno = a.id");
    $query->bindParam(":id_tarea", $_POST['id_tarea']);
    $query->execute();

    $result = array();
    while ($res = $query->fetch(PDO::FETCH_ASSOC)) {
        $result[] = $res;
    }

    echo json_encode($result);
} elseif ($_GET['parAccion'] == "guardar_recurso") {
    $_POST['archivo'] = "";
    $fileName = $_FILES["archivo"]["name"];
    $fileTmpLoc = $_FILES["archivo"]["tmp_name"];
    $fileType = $_FILES["archivo"]["type"];
    $fileSize = $_FILES["archivo"]["size"];
    $fileErrorMsg = $_FILES["archivo"]["error"];
    if (!$fileTmpLoc) {
    }
    if (move_uploaded_file($fileTmpLoc, $_SERVER['DOCUMENT_ROOT'] . "/recursos/$fileName")) {
        $_POST['archivo'] = $fileName;
    } else {
    }
    $query = $mbd->prepare("INSERT INTO recursos(id_curso, archivo, enlace) VALUES(:id_curso, :archivo, :enlace)");
    $query->bindParam(":id_curso", $_POST['id_curso']);
    $query->bindParam(":archivo", $_POST['archivo']);
    $query->bindParam(":enlace", $_POST['enlace']);
    $query->execute();

    $result = array(
        'Result' => 'OK'
    );
    echo json_encode($result);
} elseif ($_GET['parAccion'] == "eliminar_tarea") {
    $query_tarea = $mbd->prepare("SELECT * FROM tareas WHERE id = :id");
    $query_tarea->bindParam(":id", $_POST['id']);
    $query_tarea->execute();

    $tarea = $query_tarea->fetch(PDO::FETCH_ASSOC);

    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/tareas/" . $tarea['archivo'])) {
        unlink($_SERVER['DOCUMENT_ROOT'] . "/tareas/" . $tarea['archivo']);
    }

    $query_elimina = $mbd->prepare("DELETE FROM tareas WHERE id = :id");
    $query_elimina->bindParam(":id", $_POST['id']);
    $query_elimina->execute();
    $result = array(
        'Result' => 'OK'
    );
    echo json_encode($result);
} elseif ($_GET['parAccion'] == "eliminar_recurso") {
    $query_tarea = $mbd->prepare("SELECT * FROM recursos WHERE id = :id");
    $query_tarea->bindParam(":id", $_POST['id']);
    $query_tarea->execute();

    $tarea = $query_tarea->fetch(PDO::FETCH_ASSOC);

    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/recursos/" . $tarea['archivo'])) {
        unlink($_SERVER['DOCUMENT_ROOT'] . "/recursos/" . $tarea['archivo']);
    }

    $query_elimina = $mbd->prepare("DELETE FROM recursos WHERE id = :id");
    $query_elimina->bindParam(":id", $_POST['id']);
    $query_elimina->execute();
    $result = array(
        'Result' => 'OK'
    );
    echo json_encode($result);
} elseif ($_GET['parAccion'] == "guardar_tarea") {
    $_POST['archivo'] = "";
    $fileName = $_FILES["archivo"]["name"];
    $fileTmpLoc = $_FILES["archivo"]["tmp_name"];
    $fileType = $_FILES["archivo"]["type"];
    $fileSize = $_FILES["archivo"]["size"];
    $fileErrorMsg = $_FILES["archivo"]["error"];
    if (!$fileTmpLoc) {
    }
    if (move_uploaded_file($fileTmpLoc, $_SERVER['DOCUMENT_ROOT'] . "/tareas/$fileName")) {
        $_POST['archivo'] = $fileName;
    } else {
    }
    $query = $mbd->prepare("INSERT INTO tareas(id_curso, archivo, fecha_entrega, tarea) VALUES(:id_curso, :archivo, :fecha_entrega, :tarea)");
    $query->bindParam(":id_curso", $_POST['id_curso']);
    $query->bindParam(":archivo", $_POST['archivo']);
    $query->bindParam(":fecha_entrega", $_POST['fecha_entrega']);
    $query->bindParam(":tarea", $_POST['tarea']);
    $query->execute();

    $query_tema = $mbd->prepare("SELECT * FROM tbl_temas WHERE id = :id_curso");
    $query_tema->bindParam(":id_curso", $_POST['id_curso']);
    $query_tema->execute();

    $el_curso = $query_tema->fetch(PDO::FETCH_ASSOC);

    $query_alumnos = $mbd->prepare("SELECT * FROM usuarios");
    $query_alumnos->execute();

    while ($r = $query_alumnos->fetch(PDO::FETCH_ASSOC)) {
        $query_noti = $mbd->prepare("INSERT INTO notificaciones(id_usuario, id_profesor, notificacion) VALUES (:id_usuario, :id_profesor, :notificacion)");
        $query_noti->bindParam(":id_usuario", $r['id']);
        $query_noti->bindParam(":id_profesor", $_SESSION['id']);
        $notificacion = 'Una nueva tarea ha sido agregada al tema: ' . $el_curso['tema'] . '. con fecha de entrega maxima para el dia: ' . $_POST['fecha_entrega'];
        $query_noti->bindParam(":notificacion", $notificacion);
        $query_noti->execute();

        if (empty($r['correo']) || is_null($r['correo'])) {
        } else {
            $destinatario = $r['correo'];
            $cuerpo = ' 
                <html> 
                <head> 
                   <title>Notificacion de nueva tarea</title> 
                </head> 
                <body> 
                    <h1>Estimado estudiante: ' . $r['nombres'] . ' ' . $r['apellidos'] . '</h1> 
                    <p> 
                        Una nueva tarea ha sido agregada al tema: <strong>' . $el_curso['tema'] . '</strong> (' . $_POST['tarea'] . '). con fecha de entrega maxima para el dia: <strong>' . $_POST['fecha_entrega'] . '</strong>
                    </p>
                </body> 
                </html>';
            $asunto = "Nueva Tarea en la plataforma - Nabavet";

            //para el envío en formato HTML 
            $headers = "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=UTF-8\r\n";

            //dirección del remitente 
            /*$headers .= "From: Diplomados <info@nabavet.com>\r\n" .
                "CC: " . $r['correo_corporativo'];*/
            if (empty($r['correo_corporativo']) || is_null($r['correo_corporativo'])) {
                $headers .= "From: Diplomados <info@nabavet.com>\r\n";
            } else {
                $headers .= "From: Diplomados <info@nabavet.com>\r\n" .
                    "CC: " . $r['correo_corporativo'];
            }

            mail($destinatario, $asunto, $cuerpo, $headers);
        }
    }

    $result = array(
        'Result' => 'OK'
    );
    echo json_encode($result);
} elseif ($_GET['parAccion'] == "guardar_horario_profesor") {
    try {
        $mbd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $mbd->beginTransaction();

        $query_i = $mbd->prepare("INSERT INTO horarios_2(id_tema, fecha, hora_inicio, hora_fin) VALUES(:id_tema, :fecha, :hora_inicio, :hora_fin);");
        $query_i->bindParam(":hora_inicio", $_POST['hora_inicio']);
        $query_i->bindParam(":id_tema", $_POST['id_tema']);
        $query_i->bindParam(":fecha", $_POST['fecha']);
        $query_i->bindParam(":hora_fin", $_POST['hora_fin']);
        $query_i->execute();

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
} elseif ($_GET['parAccion'] == "get_horario_tema") {
    $query_horario = $mbd->prepare("SELECT * FROM horarios_2 WHERE id_tema = :id_tema");
    $query_horario->bindParam(":id_tema", $_POST['id_tema']);
    $query_horario->execute();

    $horarios = array();

    while ($res = $query_horario->fetch(PDO::FETCH_ASSOC)) {
        $horarios[] = $res;
    }

    echo json_encode($horarios);
} elseif ($_GET['parAccion'] == "lista_tareas_pendientes") {
    $data_alumno = $mbd->prepare("SELECT * FROM usuarios WHERE id = :id_alumno");
    $data_alumno->bindParam(":id_alumno", $_SESSION['id']);
    $data_alumno->execute();

    $data_alumno_ = $data_alumno->fetch(PDO::FETCH_ASSOC);



    //$query = $mbd->prepare("SELECT * FROM tareas ");
    $query = $mbd->prepare("SELECT t.*, c.curso FROM tareas as t, cursos as c WHERE c.id = t.id_curso AND c.id_grupo = :id_grupo");
    $query->bindParam(":id_grupo", $data_alumno_['id_grupo']);
    $query->execute();

    $result = array();
    while ($res = $query->fetch(PDO::FETCH_ASSOC)) {
        $query_curso = $mbd->prepare("SELECT COUNT(*) as cant FROM entrega_tarea WHERE id_tarea = :id_tarea AND id_alumno = :id_alumno");
        $query_curso->bindParam(":id_tarea", $res['id']);
        $query_curso->bindParam(":id_alumno", $_SESSION['id']);
        $query_curso->execute();

        $curso = $query_curso->fetch(PDO::FETCH_ASSOC);
        if ($curso['cant'] > 0) {
            $res['estado'] = "Y";
        } else {
            $res['estado'] = "N";
            $result[] = $res;
        }
    }

    echo json_encode($result);
} elseif ($_GET['parAccion'] == "lista_alertas") {
    /*$query = $mbd->prepare("SELECT * FROM tareas");
    $query->execute();

    $result = array();
    while ($res = $query->fetch(PDO::FETCH_ASSOC)) {
        $query_curso = $mbd->prepare("SELECT COUNT(*) as cant FROM entrega_tarea WHERE id_tarea = :id_tarea AND id_alumno = :id_alumno");
        $query_curso->bindParam(":id_tarea", $res['id']);
        $query_curso->bindParam(":id_alumno", $_SESSION['id']);
        $query_curso->execute();

        $curso = $query_curso->fetch(PDO::FETCH_ASSOC);
        if ($curso['cant'] > 0) {
        } else {
            $date1 = new DateTime($res['fecha_entrega'] . " " . "00:00:00");
            $date2 = new DateTime("now");
            $diff = $date1->diff($date2);
            if ($date1 == $date2) {
                $result[] = array(
                    'alerta' => 'Hoy es el ultimo dia de entrega de la tarea: <b>' . $res['tarea'] . '</b>',
                    'tipo' => 'danger'
                );
            } else if ($date1 < $date2) {
                $result[] = array(
                    'alerta' => $diff->d . ' dias de retraso en la entrega de la tarea: <b>' . $res['tarea'] . '</b>',
                    'tipo' => 'warning'
                );
            } else {
                if ($diff->d <= 5) {
                    $result[] = array(
                        'alerta' => 'Te quedan ' . $diff->d . ' dias para entregar la tarea: <b>' . $res['tarea'] . '</b>',
                        'tipo' => 'warning'
                    );
                }
            }
        }
    }

    echo json_encode($result);*/
    $result = array();
    $query = $mbd->prepare("SELECT n.*, CONCAT(u.nombres, ' ', u.apellidos) AS alumno, e.identificador, e.fecha as fecha_examen FROM tbl_notas as n, usuarios as u, tbl_examenes as e WHERE n.id_alumno = u.id AND n.id_examen = e.id AND n.id_alumno = " . $_SESSION['id'] . " ORDER BY n.id DESC");
    $query->execute();

    while ($res = $query->fetch(PDO::FETCH_ASSOC)) {
        $result[] = array(
            'alerta' => 'Has obtenido una nota de <strong class="badge badge-dark" style="font-size:100%;">' . $res['examen'] . '</strong> en el examen: <strong>' . $res['identificador'] . "</strong> de la fecha: " . date("Y-m-d", strtotime($res['fecha'])),
            'tipo' => 'success'
        );
    }
    echo json_encode($result);
} elseif ($_GET['parAccion'] == "get_carreras") {

    $query_universidad = $mbd->prepare("SELECT * FROM universidades WHERE id = :id_universidad");
    $query_universidad->bindParam(":id_universidad", $_POST['id_universidad']);
    $query_universidad->execute();

    $universidad = $query_universidad->fetch(PDO::FETCH_ASSOC);

    $data_carrera = $mbd->prepare("SELECT * FROM carreras WHERE id_universidad = :id_universidad");
    $data_carrera->bindParam(":id_universidad", $_POST['id_universidad']);
    $data_carrera->execute();

    $result = array();
    while ($res = $data_carrera->fetch(PDO::FETCH_ASSOC)) {
        $result[] = $res;
    }

    echo json_encode(array("universidad" => $universidad['universidad'], "carreras" => $result));
} elseif ($_GET['parAccion'] == "get_examen_2") {

    //print_r($_SESSION);
    $data_alumno = $mbd->prepare("SELECT * FROM usuarios WHERE id = :id_usuario");
    $data_alumno->bindParam(":id_usuario", $_SESSION['id']);
    $data_alumno->execute();

    $data_alumno_ = $data_alumno->fetch(PDO::FETCH_ASSOC);

    $data_carrera = $mbd->prepare("SELECT * FROM carreras WHERE id = :id_carrera");
    $data_carrera->bindParam(":id_carrera", $data_alumno_['id_carrera']);
    $data_carrera->execute();

    $data_carrera_ = $data_carrera->fetch(PDO::FETCH_ASSOC);

    $fecha = date("Y-m-d");
    $query = $mbd->prepare("SELECT * FROM tbl_examenes WHERE :fecha = fecha AND id_area = :id_area");
    $query->bindParam(":fecha", $fecha);
    $query->bindParam(":id_area", $data_carrera_['id_area']);
    $query->execute();

    $examen = $query->fetch(PDO::FETCH_ASSOC);
    $values = array();
    $vv = array();

    $notas = $mbd->prepare("SELECT COUNT(*) as cant FROM tbl_notas WHERE id_examen = :id_examen AND id_alumno = :id_alumno");
    $notas->bindParam(":id_examen", $examen['id']);
    $notas->bindParam(":id_alumno", $_SESSION['id']);
    $notas->execute();

    $cant_notas = $notas->fetch(PDO::FETCH_ASSOC);

    if ($cant_notas['cant'] > 0) {
        $values['Result'] = "DONE";
    } else {
        $values['Result'] = "OK";
        $query_2 = $mbd->prepare("SELECT * FROM preguntas_rankings WHERE id_examen = :id_examen ORDER BY n_pregunta");
        $query_2->bindParam(":id_examen", $examen['id']);
        $query_2->execute();
        $preguntas = array();

        while ($re = $query_2->fetch(PDO::FETCH_ASSOC)) {
            $preguntas[] = $re;
        }
    }



    $values['area'] = $examen['area'];
    $values['examen'] = $examen['identificador'];
    $values['nombres'] = $_SESSION['nombres'];
    $values['archivo'] = $preguntas;
    $values['n_preguntas'] = $examen['n_preguntas'];
    $values['id'] = $examen['id'];

    echo json_encode($values);
} elseif ($_GET['parAccion'] == "entregar_tarea") {
    $_POST['archivo'] = "";
    $fileName = $_FILES["file1"]["name"];
    $fileTmpLoc = $_FILES["file1"]["tmp_name"];
    $fileType = $_FILES["file1"]["type"];
    $fileSize = $_FILES["file1"]["size"];
    $fileErrorMsg = $_FILES["file1"]["error"];
    if (!$fileTmpLoc) {
    }
    if (move_uploaded_file($fileTmpLoc, $_SERVER['DOCUMENT_ROOT'] . "/entrega-tareas/$fileName")) {
        $_POST['archivo'] = $fileName;
    } else {
    }
    $query = $mbd->prepare("INSERT INTO entrega_tarea(id_tarea, archivo, id_alumno, observacion) VALUES(:id_tarea, :archivo, :id_alumno, :observacion)");
    $query->bindParam(":id_tarea", $_POST['id_tarea']);
    $query->bindParam(":archivo", $_POST['archivo']);
    $query->bindParam(":observacion", $_POST['observacion']);
    $query->bindParam(":id_alumno", $_SESSION['id']);
    $query->execute();

    echo json_encode(array("Result" => "OK"));
} elseif ($_GET['parAccion'] == "lista_tareas_entregadas") {
    $query = $mbd->prepare("SELECT e.*, t.tarea, tm.curso FROM entrega_tarea as e, tareas as t, cursos as tm WHERE tm.id = t.id_curso AND e.id_tarea = t.id AND e.id_alumno = :id_alumno ORDER BY tm.curso");
    $query->bindParam(":id_alumno", $_SESSION['id']);
    $query->execute();

    $result = array();
    while ($res = $query->fetch(PDO::FETCH_ASSOC)) {
        $result[] = $res;
    }

    echo json_encode($result);
} elseif ($_GET['parAccion'] == "crear_sala") {
    try {
        $query = $mbd->prepare("INSERT INTO salas(id_curso, sala) VALUES(:id_curso, :sala)");
        $query->bindParam(":id_curso", $_POST['id_curso']);
        $query->bindParam(":sala", $_POST['sala']);
        $query->execute();
        $result = array(
            'Result' => 'OK'
        );
        echo json_encode($result);
    } catch (PDOException $e) {
        $result = array(
            'Result' => 'ERROR'
        );
        echo json_encode($result);
    }
} elseif ($_GET['parAccion'] == "get_mis_notas") {
    $query = $mbd->prepare("SELECT m.modulo, n.* FROM tbl_modulos as m, tbl_notas as n WHERE n.id_modulo = m.id AND n.id_alumno = :id_alumno");
    $query->bindParam(":id_alumno", $_SESSION['id']);

    $query->execute();

    $result = array();
    while ($res = $query->fetch(PDO::FETCH_ASSOC)) {
        $result[] = $res;
    }

    echo json_encode($result);
} elseif ($_GET['parAccion'] == "resolver") {
    $correctas = 0;
    $incorrectas = 0;
    $noRespondidas = 0;
    $puntaje = 0;

    try {
        $mbd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $mbd->beginTransaction();

        $querye = $mbd->prepare("DELETE FROM resueltas WHERE id_alumno = :id_alumno AND id_examen = :id_examen");
        $querye->bindParam(":id_alumno", $_SESSION['id']);
        $querye->bindParam(":id_examen", $_POST['id_examen']);
        $querye->execute();

        $cant_preguntas = $mbd->prepare("SELECT * FROM tbl_examenes WHERE id = :id");
        $cant_preguntas->bindParam(":id", $_POST['id_examen']);
        $cant_preguntas->execute();

        $cant_preguntas_ = $cant_preguntas->fetch(PDO::FETCH_ASSOC);

        $query = $mbd->prepare("SELECT * FROM respuestas WHERE id_examen = :id_examen ORDER BY n_pregunta ASC");
        $query->bindParam(":id_examen", $_POST['id_examen']);
        $query->execute();

        $aux = 0;
        while ($res = $query->fetch(PDO::FETCH_ASSOC)) {
            $aux++;
            if ($aux > 50) {
            } else {
                $letter = "";
                if ($_POST['letras'][$aux] == "" || is_null($_POST['letras'][$aux])) {
                    $letter = "";
                } else {
                    $letter = $_POST['letras'][$aux];
                }
                $ist = $mbd->prepare("INSERT INTO resueltas(id_alumno, id_examen, n_pregunta, letra, curso) VALUES(:id_alumno, :id_examen, :n_pregunta, :letra, :curso)");
                $ist->bindParam(":id_alumno", $_SESSION['id']);
                $ist->bindParam(":id_examen", $_POST['id_examen']);
                $ist->bindParam(":n_pregunta", $aux);
                $ist->bindParam(":letra", $letter);
                $ist->bindParam(":curso", $res['curso']);
                $ist->execute();
                if (empty($_POST['letras'][$aux]) || $_POST['letras'][$aux] == null || $_POST['letras'][$aux] == "") {
                    $noRespondidas++;
                } else {
                    if ($res['letra'] == $_POST['letras'][$aux]) {
                        $correctas++;
                    } else {
                        $incorrectas++;
                    }
                }
            }
        }

        //$valor = 20 / $cant_preguntas_['n_preguntas'];
        $valor = 2;

        $puntaje = $correctas * $valor;

        $query_elimina_nota = $mbd->prepare("DELETE FROM tbl_notas WHERE id_alumno = :id_alumno AND id_examen = :id_examen");
        $query_elimina_nota->bindParam(":id_alumno", $_SESSION['id']);
        $query_elimina_nota->bindParam(":id_examen", $cant_preguntas_['id']);
        $query_elimina_nota->execute();

        $query_guardar_nota = $mbd->prepare("INSERT INTO tbl_notas(id_alumno, examen, id_examen) VALUES (:id_alumno, :examen, :id_examen);");
        $query_guardar_nota->bindParam(":id_alumno", $_SESSION['id']);
        $query_guardar_nota->bindParam(":examen", $puntaje);
        $query_guardar_nota->bindParam(":id_examen", $cant_preguntas_['id']);
        $query_guardar_nota->execute();



        $values = array(
            "nota" => $puntaje,
            "correctas" => $correctas,
            "incorrectas" => $incorrectas,
            "noRespondidas" => $noRespondidas
        );

        $mbd->commit();
        echo json_encode($values);
    } catch (Exception $e) {
        $mbd->rollBack();
        $result = array(
            'Result' => 'ERROR',
            'Message' => $e->getMessage()
        );
        echo json_encode($result);
    }
} elseif ($_GET['parAccion'] == "get_cursos") {
    $query = $mbd->prepare("SELECT id_carrera, id_universidad, id_ciclo, id_grupo FROM usuarios WHERE id = :id");
    $query->bindParam(":id", $_SESSION['id']);
    $query->execute();

    $data = $query->fetch(PDO::FETCH_ASSOC);

    $query_grupo = $mbd->prepare("SELECT * FROM grupos WHERE id = :id_grupo");
    $query_grupo->bindParam(":id_grupo", $data['id_grupo']);
    $query_grupo->execute();

    $grupo = $query_grupo->fetch(PDO::FETCH_ASSOC);

    $query_cursos = $mbd->prepare("SELECT * FROM cursos WHERE id_grupo = :id_grupo");
    $query_cursos->bindParam(":id_grupo", $grupo['id']);
    $query_cursos->execute();

    $result = array();

    while ($res = $query_cursos->fetch(PDO::FETCH_ASSOC)) {
        $query_profesor = $mbd->prepare("SELECT * FROM profesores WHERE id = :id_profesor");
        $query_profesor->bindParam(":id_profesor", $res['id_profesor']);
        $query_profesor->execute();
        $profesor = $query_profesor->fetch(PDO::FETCH_ASSOC);

        $res['profesor'] = $profesor['apellidos'] . " " . $profesor['nombres'];
        $result[] = $res;
    }

    echo json_encode($result);
} elseif ($_GET['parAccion'] == "get_temas") {
    $query = $mbd->prepare("SELECT t.*, c.curso FROM tbl_temas as t, cursos as c WHERE t.id_curso = :id_curso AND t.id_curso = c.id");
    $query->bindParam(":id_curso", $_POST['id_curso']);
    $query->execute();

    $result = array();

    while ($res = $query->fetch(PDO::FETCH_ASSOC)) {
        $result[] = $res;
    }

    echo json_encode($result);
} elseif ($_GET['parAccion'] == "get_rankings") {
    try {
        $mbd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $mbd->beginTransaction();


        $query = $mbd->prepare("SELECT DISTINCT r.id, r.identificador FROM tbl_examenes as r, resueltas as re WHERE r.id = re.id_examen AND re.id_alumno = :id_alumno");
        $query->bindParam(":id_alumno", $_SESSION['id']);
        $query->execute();

        $values = array();

        while ($res = $query->fetch(PDO::FETCH_ASSOC)) {
            $values[] = $res;
        }

        $mbd->commit();
        $result = array(
            'Result' => 'OK',
            'Records' => $values
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
} elseif ($_GET['parAccion'] == "get_estadisticas") {
    $correctas = 0;
    $incorrectas = 0;
    $noRespondidas = 0;
    $puntaje = 0;

    try {
        $mbd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $mbd->beginTransaction();

        $cant_preguntas = $mbd->prepare("SELECT * FROM tbl_examenes WHERE id = :id");
        $cant_preguntas->bindParam(":id", $_POST['id_ranking']);
        $cant_preguntas->execute();

        $cant_preguntas_ = $cant_preguntas->fetch(PDO::FETCH_ASSOC);

        $query = $mbd->prepare("SELECT re.curso, re.n_pregunta, re.letra as respuesta, rp.letra as clave FROM resueltas as re, respuestas as rp WHERE re.id_examen = rp.id_examen AND rp.n_pregunta = re.n_pregunta AND re.id_examen = :id_examen AND re.id_alumno = :id_alumno ORDER BY rp.n_pregunta");
        $query->bindParam(":id_alumno", $_SESSION['id']);
        $query->bindParam(":id_examen", $_POST['id_ranking']);
        $query->execute();

        $values = array();
        $valores = array();

        $cfd = array();

        while ($res = $query->fetch(PDO::FETCH_ASSOC)) {
            $query_imagen = $mbd->prepare("SELECT * FROM preguntas_rankings WHERE id_examen = :id_examen AND n_pregunta = :n_pregunta");
            $query_imagen->bindParam(":id_examen", $_POST['id_ranking']);
            $query_imagen->bindParam(":n_pregunta", $res['n_pregunta']);
            $query_imagen->execute();

            $imagenes_preguntas = $query_imagen->fetch(PDO::FETCH_ASSOC);

            $res['enunciado'] = $imagenes_preguntas['enunciado'];
            $res['pregunta'] = $imagenes_preguntas['pregunta'];

            $correctas_ = 0;
            $incorrectas_ = 0;
            $noRespondidas_ = 0;
            $puntaje_ = 0;

            $query_curso = $mbd->prepare("SELECT * FROM cursos WHERE codigo = :curso");
            $query_curso->bindParam(":curso", $res['curso']);
            $query_curso->execute();

            $data_curso = $query_curso->fetch(PDO::FETCH_ASSOC);

            $no_se = $mbd->prepare("SELECT c.curso as curso_, re.n_pregunta, re.letra as respuesta, rp.letra as clave FROM resueltas as re, respuestas as rp, cursos as c WHERE c.codigo = re.curso AND re.id_examen = rp.id_examen AND rp.n_pregunta = re.n_pregunta AND re.id_examen = :id_examen AND re.id_alumno = :id_alumno AND c.id = :curso ORDER BY rp.n_pregunta");
            $no_se->bindParam(":id_alumno", $_SESSION['id']);
            $no_se->bindParam(":id_examen", $_POST['id_ranking']);
            $no_se->bindParam(":curso", $data_curso['id']);
            $no_se->execute();
            $cdu = "";
            $tot = 0;
            while ($r = $no_se->fetch(PDO::FETCH_ASSOC)) {
                $cdu = $r['curso_'];
                if (empty($r['respuesta']) || $r['respuesta'] == null || $r['respuesta'] == "") {
                    $noRespondidas_++;
                } else {
                    if ($r['respuesta'] == $r['clave']) {
                        $correctas_++;
                    } else {
                        $incorrectas_++;
                    }
                }
            }

            $cfd[$cdu] = array(
                "correctas" => $correctas_,
                "incorrectas" => $incorrectas_,
                "noRespondidas" => $noRespondidas_
            );

            $valores[] = $res;
            if (empty($res['respuesta']) || $res['respuesta'] == null || $res['respuesta'] == "") {
                $noRespondidas++;
            } else {
                if ($res['respuesta'] == $res['clave']) {
                    $correctas++;
                } else {
                    $incorrectas++;
                }
            }
        }

        $cants = $mbd->prepare("SELECT c.curso, COUNT(r.curso) as cant FROM cursos as c, respuestas as r WHERE r.curso = c.codigo AND r.id_examen = :id_examen GROUP BY c.curso");
        $cants->bindParam(":id_examen", $_POST['id_ranking']);
        $cants->execute();

        $cursos = array();

        while ($res = $cants->fetch(PDO::FETCH_ASSOC)) {
            $cursos[] = $res['curso'];
        }

        $flo_ = array();

        //$puntaje = $correctas * 80/100;
        //$puntaje = $correctas * 100 / $cant_preguntas_['n_preguntas'];
        $puntaje = $correctas * 100 / 50;
        //$puntaje = $correctas * 100 / 70;

        $values = array(
            "nota" => $puntaje,
            "correctas" => $correctas,
            "incorrectas" => $incorrectas,
            "noRespondidas" => $noRespondidas
        );

        $mbd->commit();
        $result = array(
            'Result' => 'OK',
            'Records' => $values,
            'Valores' => $valores,
            'Cursos' => $cursos,
            'flo' => $cfd
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
} elseif ($_GET['parAccion'] == "data_carpeta") {
    $query = $mbd->prepare("SELECT * FROM biblioteca WHERE id = :id_carpeta");
    $query->bindParam(":id_carpeta", $_POST['id_carpeta']);
    $query->execute();
    $result = array();

    /*while ($res = $query->FETCH_ASSOC(PDO::FETCH_ASSOC)) {
        $result[] = $res;
    }*/
    //echo $mono->select_one("biblioteca", array("id" => $_POST['id_carpeta']));
    echo json_encode($query->fetch(PDO::FETCH_ASSOC));
} elseif ($_GET['parAccion'] == "lista_carpetas") {
    $query = $mbd->prepare("SELECT * FROM biblioteca WHERE id_padre IS NULL or id_padre = 0 or id_padre = ''");
    $query->execute();
    $result = array();

    while ($res = $query->fetch(PDO::FETCH_ASSOC)) {
        $result[] = $res;
    }
    echo json_encode($result);
} elseif ($_GET['parAccion'] == "lista_contenido") {
    $sql = $mbd->prepare("SELECT * FROM contenido_biblioteca WHERE id_carpeta = " . $_POST['id_carpeta']);
    //$contenido = json_decode($mono->run_query($sql, false));
    $sql->execute();


    $sql_2 = $mbd->prepare("SELECT * FROM biblioteca WHERE id_padre = " . $_POST['id_carpeta']);
    //$carpetas = json_decode($mono->run_query($sql_2, false));
    $sql_2->execute();

    //$sql_3 = json_decode($mono->select_one("biblioteca", array("id" => $_POST['id_carpeta'])));
    $sql_3 = $mbd->prepare("SELECT * FROM biblioteca WHERE id = :id_carpeta");
    $sql_3->bindParam(":id_carpeta", $_POST['id_carpeta']);
    $sql_3->execute();
    $sql_3_ = $sql_3->fetch(PDO::FETCH_ASSOC);

    $padre_nombre = "";

    //echo "string ".$sql_3_['id_padre'];

    if ($sql_3_['id_padre'] == "" || is_null($sql_3_['id_padre']) || empty($sql_3_['id_padre'])) {
        $padre_nombre = "NO";
    } else {
        //$padre = json_decode($mono->select_one("biblioteca", array("id" => $sql_3_['id_padre'])));
        $padre = $mbd->prepare("SELECT * FROM biblioteca WHERE id = :id_padre");
        $padre->bindParam(":id_padre", $sql_3_['id_padre']);
        $padre->execute();
        $padre_ = $padre->fetch(PDO::FETCH_ASSOC);

        $padre_nombre = $padre_['nombre_carpeta'];
    }



    $result = array();

    while ($value = $sql_2->fetch(PDO::FETCH_ASSOC)) {
        $result[] = array(
            "id" => $value['id'],
            "nombre_carpeta" => $value['nombre_carpeta'],
            "id_padre" => $value['id_padre'],
            "padre" => $padre_nombre,
            "type" => "C"
        );
    }

    while ($value = $sql->fetch(PDO::FETCH_ASSOC)) {
        $result[] = array(
            "id" => $value['id'],
            "archivo" => $value['archivo'],
            "id_carpeta" => $value['id_carpeta'],
            "padre" => $padre_nombre,
            "type" => "A"
        );
    }

    echo json_encode($result);
} elseif ($_GET['parAccion'] == "lista_ciclos_y_grupos") {
    $query = $mbd->prepare("SELECT g.*, c.ciclo FROM ciclos as c, grupos as g WHERE g.id_ciclo = c.id AND c.activo NOT IN (1)");
    $query->execute();

    $result = array();

    while ($res = $query->fetch(PDO::FETCH_ASSOC)) {
        $result[] = $res;
    }
    echo json_encode($result);
} elseif ($_GET['parAccion'] == "get_cursos_anteriores") {
    /*$query = $mbd->prepare("SELECT id_carrera, id_universidad, id_ciclo, id_grupo FROM usuarios WHERE id = :id");
    $query->bindParam(":id", $_SESSION['id']);
    $query->execute();

    $data = $query->fetch(PDO::FETCH_ASSOC);*/

    $query_grupo = $mbd->prepare("SELECT * FROM grupos WHERE id = :id_grupo");
    $query_grupo->bindParam(":id_grupo", $_POST['id_grupo']);
    $query_grupo->execute();

    $grupo = $query_grupo->fetch(PDO::FETCH_ASSOC);

    $query_cursos = $mbd->prepare("SELECT * FROM cursos WHERE id_grupo = :id_grupo");
    $query_cursos->bindParam(":id_grupo", $grupo['id']);
    $query_cursos->execute();

    $result = array();

    while ($res = $query_cursos->fetch(PDO::FETCH_ASSOC)) {
        $query_profesor = $mbd->prepare("SELECT * FROM profesores WHERE id = :id_profesor");
        $query_profesor->bindParam(":id_profesor", $res['id_profesor']);
        $query_profesor->execute();
        $profesor = $query_profesor->fetch(PDO::FETCH_ASSOC);

        $res['profesor'] = $profesor['apellidos'] . " " . $profesor['nombres'];
        $result[] = $res;
    }

    echo json_encode($result);
} elseif ($_GET['parAccion'] == "getSchedule_category") {
    $query = $mbd->prepare("SELECT id, name, color, bgColor, dragBgColor, borderColor, user_creation, date_creation FROM schedule_category");
    $query->execute();
    $values = array();
    while ($res = $query->fetch(PDO::FETCH_ASSOC)) {
        $values[] = $res;
    }
    echo json_encode(
        array(
            "Result" => "OK",
            "Values" => $values
        )
    );
} elseif ($_GET['parAccion'] == 'getSchedule_save') {
    /*$encodedData = file_get_contents('php://input');
    $decodedData = json_decode($encodedData, true);*/

    try {
        $mbd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $mbd->beginTransaction();
        $query = $mbd->prepare("INSERT INTO eventos(title, isAllDay, start, end, category, dueDateClass, color, bgColor, dragBgColor, borderColor, location, isPrivate, state) VALUES (:title, :isAllDay, :start, :end, :category, :dueDateClass, :color, :bgColor, :dragBgColor, :borderColor, :location, :isPrivate, :state)");
        $query->bindValue(':title', $_POST['title']);
        $query->bindValue(':isAllDay', $_POST['isAllDay']);
        $query->bindValue(':start', $_POST['start']);
        $query->bindValue(':end', $_POST['end']);
        $query->bindValue(':category', $_POST['category']);
        $query->bindValue(':dueDateClass', $_POST['dueDateClass']);
        $query->bindValue(':color', $_POST['color']);
        $query->bindValue(':bgColor', $_POST['bgColor']);
        $query->bindValue(':dragBgColor', $_POST['dragBgColor']);
        $query->bindValue(':borderColor', $_POST['borderColor']);
        $query->bindValue(':location', $_POST['location']);
        $query->bindValue(':isPrivate', $_POST['isPrivate']);
        $query->bindValue(':state', $_POST['state']);
        $query->execute();

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
} elseif ($_GET['parAccion'] == 'getSchedule_list') {
    $query = $mbd->prepare("SELECT * FROM eventos;");
    $query->execute();
    $values = array();
    while ($res = $query->fetch(PDO::FETCH_ASSOC)) {
        $values[] = $res;
    }
    echo json_encode($values);
}
