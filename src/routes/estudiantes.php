<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


$app = new \Slim\App;









//MODULO DEL ESTUDIANTE




//Obtener todos los estudiantes
/*
$app->get('/estudiantes', function(Request $request, Response $response){
    $consulta = "SELECT * FROM estudiantes";
    try{
        // Instanciar la base de datos
        $db = new db();

        // Conexión
        $db = $db->conectar();
        $ejecutar = $db->query($consulta);
        $estudiantes = $ejecutar->fetchAll(PDO::FETCH_OBJ);
        $db = null;

        //Exportar y mostrar en formato JSON
        echo json_encode($estudiantes);

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
*/



//Obtener un solo estudiante
$app->get('/estudiante/{id}', function(Request $request, Response $response){

    $id = $request->getAttribute('id');


     $consulta = "SELECT p.Nombre_Persona as nombre, p.Telefono_Persona as tel,e.Carne_estudiante as carne,p.Direccion_Persona,p.Email_Persona
        from personas as p
        inner join estudiantes as e
        on (p.Id_Persona=e.Id_Persona) WHERE e.Id_Estudiante='$id'";

    try{
        // Instanciar la base de datos
        $db = new db();

        // Conexión
        $db = $db->conectar();
        $ejecutar = $db->query($consulta);
        $estudiante = $ejecutar->fetchAll(PDO::FETCH_OBJ);
        $db = null;

        //Exportar y mostrar en formato JSON
        echo json_encode($estudiante);

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});









//Verificacion de logeo
$app->get('/validacionEstudiante/{carne}', function(Request $request, Response $response){

    $carne = $request->getAttribute('carne');
    $contrasena=$request->getParam('contrasena');

    $consulta=("SELECT e.Id_Estudiante,e.Carne_estudiante as Carne_Pasante,p.Nombre_Persona,p.Usuario_Persona,p.pass_Persona as Contrasena_Persona FROM estudiantes as e INNER JOIN personas as p ON e.Id_Persona=p.Id_Persona WHERE e.Carne_estudiante='$carne'");


    try{
            // Instanciar la base de datos
            $db = new db();

            // Conexión
            $db = $db->conectar();
            $ejecutar = $db->query($consulta);
            $avisos = $ejecutar->fetchAll(PDO::FETCH_OBJ);
             $db = null;

            if($avisos==null)
            {
                echo json_encode("Datos incorrectos");
            }
            else
            {
               echo json_encode($avisos);
            }
    }
     catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});






//Casos del Estudiante
$app->get('/casos/{id_estudiante}', function(Request $request, Response $response){

    $id_estudiante = $request->getAttribute('id_estudiante');


    $consulta=("SELECT No_Caso as Caso,tipo as Tipo,Nombre_Demandante as Demandante, Nombre_Demandado as Demandado,Tribunal
        FROM `casos` as c
        inner join `demandantes` AS d1 ON (d1.id_Demandante=c.id_demandante)
        inner join `tipocaso` AS tip ON(tip.id_tipo=c.id_Tipo)
        inner join `tribunales` AS trib On(trib.id_tribunal=c.id_tribunal)
        WHERE id_estudiante='$id_estudiante'");


    try{
            // Instanciar la base de datos
            $db = new db();

            // Conexión
            $db = $db->conectar();
            $ejecutar = $db->query($consulta);
            $estudiante = $ejecutar->fetchAll(PDO::FETCH_OBJ);
             $db = null;

            if($estudiante==null)
            {
                echo json_encode("Datos incorrectos");
            }
            else
            {
               echo json_encode($estudiante);
            }
    }
     catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});









//Todas las notificaciones del estudiante
$app->get('/notificacionesEstudiante/{id_estudiante}', function(Request $request, Response $response){

    $id_estudiante = $request->getAttribute('id_estudiante');


    $consulta=("SELECT id_aviso, Date(fecha_visita) as Fecha,c.no_caso as Codigo_Caso, p.nombre_persona as Estudiante, d.nombre_demandante as Demandante, descripcion as Descripcion, t.tipo as Tipo_Caso,a.vista as Vista
        from aviso_notificacion as a
        inner join casos as c on (a.id_caso=c.id_caso)
        inner join tipocaso as t on (c.Id_Tipo=t.Id_Tipo)
        inner join demandantes as d on a.id_demandante=d.id_demandante
        inner join estudiantes as e on (a.id_estudiante=e.id_estudiante)
        inner join personas as p on (e.id_persona=p.id_persona)
        WHERE e.id_estudiante='$id_estudiante' ORDER BY fecha_visita DESC");


    try{
            // Instanciar la base de datos
            $db = new db();

            // Conexión
            $db = $db->conectar();
            $ejecutar = $db->query($consulta);
            $estudiante = $ejecutar->fetchAll(PDO::FETCH_OBJ);
             $db = null;

            if($estudiante==null)
            {
                echo json_encode("Datos incorrectos");
            }
            else
            {
               echo json_encode($estudiante);
            }
    }
     catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});





//Todas las notificaciones del estudiante Vistas
$app->get('/notificacionesVistasEstudiante/{id_estudiante}', function(Request $request, Response $response){

    $id_estudiante = $request->getAttribute('id_estudiante');


    $consulta=("SELECT id_aviso, Date(fecha_visita) as Fecha,c.no_caso as Codigo_Caso, p.nombre_persona as Estudiante, d.nombre_demandante as Demandante, descripcion as Descripcion, t.tipo as Tipo_Caso from aviso_notificacion as a
     inner join casos as c on (a.id_caso=c.id_caso) inner join tipocaso as t on (c.Id_Tipo=t.Id_Tipo)
     inner join demandantes as d on a.id_demandante=d.id_demandante inner join estudiantes as e on (a.id_estudiante=e.id_estudiante)
     inner join personas as p on (e.id_persona=p.id_persona)
       WHERE e.id_estudiante='$id_estudiante' and a.vista=1 ORDER BY fecha_visita DESC");


    try{
            // Instanciar la base de datos
            $db = new db();

            // Conexión
            $db = $db->conectar();
            $ejecutar = $db->query($consulta);
            $estudiante = $ejecutar->fetchAll(PDO::FETCH_OBJ);
             $db = null;

            if($estudiante==null)
            {
                echo json_encode("El estudiante no tiene alguna notificacion Vista");
            }
            else
            {
               echo json_encode($estudiante);
            }
    }
     catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});




//Todas las notificaciones del estudiante no Vistas
$app->get('/notificacionesNoVistasEstudiante/{id_estudiante}', function(Request $request, Response $response){

    $id_estudiante = $request->getAttribute('id_estudiante');


    $consulta=("SELECT id_aviso, Date(fecha_visita) as Fecha,c.no_caso as Codigo_Caso, p.nombre_persona as Estudiante, d.nombre_demandante as Demandante, descripcion as Descripcion, t.tipo as Tipo_Caso
        from aviso_notificacion as a inner join casos as c on (a.id_caso=c.id_caso) inner join tipocaso as t on (c.Id_Tipo=t.Id_Tipo) inner join demandantes as d on a.id_demandante=d.id_demandante inner join estudiantes as e on (a.id_estudiante=e.id_estudiante) inner join personas as p on (e.id_persona=p.id_persona)
         WHERE e.id_estudiante='$id_estudiante' and a.vista=0 ORDER BY fecha_visita DESC");


    try{
            // Instanciar la base de datos
            $db = new db();

            // Conexión
            $db = $db->conectar();
            $ejecutar = $db->query($consulta);
            $estudiante = $ejecutar->fetchAll(PDO::FETCH_OBJ);
             $db = null;

            if($estudiante==null)
            {
                echo json_encode("El estudiante no tiene ninguna notificacion no Vista");
            }
            else
            {
               echo json_encode($estudiante);
            }
    }
     catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});








//Obtener una notificacion
$app->get('/detalleNotificacion/{id}', function(Request $request, Response $response){

    $id = $request->getAttribute('id');


$consulta=("SELECT id_aviso, Date(fecha_visita) as Fecha,Time(fecha_visita) as Hora,c.no_caso as Codigo_Caso, p.nombre_persona as Estudiante,d.nombre_demandante as Demandante,
    ases.nombre_persona as Asesor,descripcion as Descripcion, t.tipo as Tipo_Caso

    from aviso_notificacion as a
    inner join casos as c on (a.id_caso=c.id_caso)
    inner join tipocaso as t on (c.Id_Tipo=t.Id_Tipo)
    inner join demandantes as d on a.id_demandante=d.id_demandante
    inner join estudiantes as e on (a.id_estudiante=e.id_estudiante)
    inner join personas as p on (e.id_persona=p.id_persona)
    inner join personas as ases on (ases.id_persona=a.id_persona) WHERE  id_aviso='$id'");


    try{
        // Instanciar la base de datos
        $db = new db();

        // Conexión
        $db = $db->conectar();
        $ejecutar = $db->query($consulta);
        $estudiante = $ejecutar->fetchAll(PDO::FETCH_OBJ);
        $db = null;

        //Exportar y mostrar en formato JSON
        echo json_encode($estudiante);

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});









//Obtener los casos
$app->get('/detalleCaso/{id}', function(Request $request, Response $response){

    $id = $request->getAttribute('id');


$consulta=("SELECT No_Caso as Caso,Fecha_Caso as Fecha,Nombre_Demandante as Demandante,Nombre_Demandado as Demandado,Tipo,Tribunal,ase.Nombre_Persona as Asesor,estu.Nombre_Persona as Estudiante,
Asunto,Estado_Caso as Estado
FROM `casos` as c INNER JOIN `demandantes` AS d1 ON (d1.Id_Demandante=c.Id_Demandante)
inner join `tipocaso` AS tip ON(tip.Id_Tipo=c.Id_Tipo)
inner join `tribunales` as trib on (trib.Id_Tribunal=c.Id_Tribunal)
inner join `personas` as ase on(ase.Id_Persona=c.Id_Persona)
inner join `personas` as estu on(estu.Id_Persona=c.Id_Estudiante)
inner join `tipoasunto`as asunto on(asunto.Id_TipoAsunto=c.Id_TipoAsunto) WHERE No_Caso='$id'");


    try{
        // Instanciar la base de datos
        $db = new db();

        // Conexión
        $db = $db->conectar();
        $ejecutar = $db->query($consulta);
        $estudiante = $ejecutar->fetchAll(PDO::FETCH_OBJ);
        $db = null;

        //Exportar y mostrar en formato JSON
        echo json_encode($estudiante);

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});









//METODOS AL SELECCIONAR LA NOTIFICACION



//cambiar a vista y colocar fecha
$app->post('/cambiarNotificacionVista/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');
    $vista=1;


     $consulta = "UPDATE  aviso_notificacion SET
                hora_visita = now(),
                vista = :vista
            WHERE id_aviso = $id";

    try{
        // Instanciar la base de datos
        $db = new db();

        // Conexion
        $db = $db->conectar();
        $stmt = $db->prepare($consulta);
        $stmt->bindParam(':vista',$vista);
        $stmt->execute();
        echo '{"notice": {"text": "Notificacion vista"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }


});





























































































//MODULO DE ASESORES




//Obtener todos los asesores
/*
$app->get('/asesores', function(Request $request, Response $response){
    $consulta = "SELECT * FROM `personas` where role='ROLE_ASESOR'";
    try{
        // Instanciar la base de datos
        $db = new db();

        // Conexión
        $db = $db->conectar();
        $ejecutar = $db->query($consulta);
        $estudiantes = $ejecutar->fetchAll(PDO::FETCH_OBJ);
        $db = null;

        //Exportar y mostrar en formato JSON
        echo json_encode($estudiantes);

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
*/



//Obtener un solo esesor
$app->get('/asesor/{id}', function(Request $request, Response $response){

    $id = $request->getAttribute('id');


     $consulta = "SELECT * FROM `personas` WHERE role='ROLE_ASESOR' AND id_persona='$id'";

    try{
        // Instanciar la base de datos
        $db = new db();

        // Conexión
        $db = $db->conectar();
        $ejecutar = $db->query($consulta);
        $estudiante = $ejecutar->fetchAll(PDO::FETCH_OBJ);
        $db = null;

        //Exportar y mostrar en formato JSON
        echo json_encode($estudiante);

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});









//Verificacion de logeo
$app->get('/validacionAsesor/{usuario}', function(Request $request, Response $response){

    $usuario = $request->getAttribute('usuario');

    $consulta=("SELECT * FROM `personas` WHERE role='ROLE_ASESOR' AND usuario_persona='$usuario'");

    try{
            // Instanciar la base de datos
            $db = new db();

            // Conexión
            $db = $db->conectar();
            $ejecutar = $db->query($consulta);
            $avisos = $ejecutar->fetchAll(PDO::FETCH_OBJ);
             $db = null;

            if($avisos==null)
            {
                echo json_encode("Datos incorrectos");
            }
            else
            {
               echo json_encode($avisos);
            }
    }
     catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});






//Lista todos los casos en donde el asesor esta involucrado
$app->get('/listaCasosAsesor/{id_persona}', function(Request $request, Response $response){

    $id_asesor = $request->getAttribute('id_persona');


$consulta=("SELECT No_Caso as Caso,es.id_estudiante as Id_Estudiante,estu.nombre_persona as Estudiante,es.Carne_estudiante,tipo as Tipo,Nombre_Demandante as Demandante, Nombre_Demandado as Demandado,Tribunal
        FROM `casos` as c
        inner join `demandantes` AS d1 ON (d1.id_Demandante=c.id_demandante)
        inner join `tipocaso` AS tip ON(tip.id_tipo=c.id_Tipo)
        inner join `tribunales` AS trib On(trib.id_tribunal=c.id_tribunal)
        inner join `personas` AS estu on(estu.id_persona=c.id_estudiante)
        inner join `personas` AS ases on(ases.id_persona=c.id_persona)
        inner join `estudiantes` AS es on(es.id_estudiante=c.id_estudiante)

        WHERE ases.role='ROLE_ASESOR' AND  c.id_persona='$id_asesor'");

    try{
            // Instanciar la base de datos
            $db = new db();

            // Conexión
            $db = $db->conectar();
            $ejecutar = $db->query($consulta);
            $estudiante = $ejecutar->fetchAll(PDO::FETCH_OBJ);
             $db = null;

            if($estudiante==null)
            {
                echo json_encode("Datos incorrectos");
            }
            else
            {
               echo json_encode($estudiante);
            }
    }
     catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});







//Lista todos los casos en donde el asesor esta involucrado
$app->get('/listaEstudiantesAsesor/{id_persona}', function(Request $request, Response $response){

    $id_asesor = $request->getAttribute('id_persona');


$consulta=("SELECT No_Caso as Caso,estu.Nombre_Persona as Estudiante,es.Id_Estudiante,es.Carne_estudiante as Carne
        FROM `casos` as c
        inner join `personas` AS estu on(estu.id_persona=c.id_estudiante)
        inner join `personas` AS ases on(ases.id_persona=c.id_persona)
        inner join `estudiantes` as es on(es.id_estudiante=c.id_estudiante)
        WHERE ases.role='ROLE_ASESOR' AND  c.id_persona='$id_asesor'");

    try{
            // Instanciar la base de datos
            $db = new db();

            // Conexión
            $db = $db->conectar();
            $ejecutar = $db->query($consulta);
            $estudiante = $ejecutar->fetchAll(PDO::FETCH_OBJ);
             $db = null;

            if($estudiante==null)
            {
                echo json_encode("Datos incorrectos");
            }
            else
            {
               echo json_encode($estudiante);
            }
    }
     catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});








//Todas las notificaciones del asesor
$app->get('/notificacionesAsesor/{id_persona}', function(Request $request, Response $response){

    $id_asesor = $request->getAttribute('id_persona');


$consulta=("SELECT id_aviso, Date(fecha_visita) as Fecha,c.no_caso as Codigo_Caso, p.nombre_persona as Estudiante,ases.Nombre_Persona as Asesor, d.nombre_demandante as Demandante, descripcion as Descripcion, t.tipo as Tipo_Caso,a.vista as Vista
        from aviso_notificacion as a inner join casos as c on (a.id_caso=c.id_caso)
        inner join tipocaso as t on (c.Id_Tipo=t.Id_Tipo)
        inner join demandantes as d on a.id_demandante=d.id_demandante
        inner join estudiantes as e on (a.id_estudiante=e.id_estudiante)
        inner join personas as p on (e.id_persona=p.id_persona)
        inner join personas as ases on(ases.Id_Persona=c.Id_Persona)
        WHERE ases.role='ROLE_ASESOR' AND ases.id_persona='$id_asesor'
        ORDER BY fecha_visita DESC");


    try{
            // Instanciar la base de datos
            $db = new db();

            // Conexión
            $db = $db->conectar();
            $ejecutar = $db->query($consulta);
            $estudiante = $ejecutar->fetchAll(PDO::FETCH_OBJ);
             $db = null;

            if($estudiante==null)
            {
                echo json_encode("Datos incorrectos");
            }
            else
            {
               echo json_encode($estudiante);
            }
    }
     catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
