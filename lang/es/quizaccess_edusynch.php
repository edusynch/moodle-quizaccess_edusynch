<?php 
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.
/**
 * String file - ES
 * 
 * @package    quizaccess_edusynch
 * @category   quiz
 * @copyright  2022 EduSynch <contact@edusynch.com>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


// Plugin name
$string['pluginname'] = 'EduSynch E-Proctoring';

// Capabilities
$string['edusyncheproctoring:view_report'] = 'Puede ver los informes de E-Proctoring';
$string['edusyncheproctoring:edit_settings'] = 'Puede editar las configuraciones de E-Proctoring';
$string['edusyncheproctoring:enable_quiz'] = 'Puede habilitar la extensión de E-Proctoring';

// Miscellaneous 
$string['misc:btn_prev'] = 'Anterior';
$string['misc:btn_next'] = 'Siguiente';
$string['misc:success'] = '¡Realizado con éxito!';
$string['misc:error'] = 'Error';
$string['misc:yes'] = 'Sí';
$string['misc:no'] = 'No';
$string['misc:label_total_pages'] = 'de {$a}';


// Config page
$string['config:keys'] = 'Claves';
$string['config:api_key'] = 'Clave de API';
$string['config:token'] = 'Token';
$string['config:generate_token'] = 'Generar Token';
$string['config:students_api'] = 'API de Estudiantes';
$string['config:cms_api'] = 'API de CMS';
$string['config:events_api'] = 'API de Eventos';
$string['config:user'] = 'Usuario';
$string['config:password'] = 'Contraseña';
$string['config:save'] = 'Salvar';
$string['config:import_students'] = 'Importar estudiantes';
$string['config:total_students']  = 'Tienes <strong>{$a}</strong> estudiantes habilitados.';
$string['config:import_students_desc'] = 'Use el cuadro a continuación para importar un archivo .CSV con los datos de sus estudiantes, como';
$string['config:import_students_desc_link'] = 'este ejemplo';
$string['config:import_students_file'] = 'Archivo CSV';
$string['config:courses_enabled'] = 'Cursos habilitados';
$string['config:manage_courses'] = 'Administrar Cursos';
$string['config:list_courses'] = 'Lista';
$string['config:course'] = 'Curso';
$string['config:courses'] = 'Cursos';
$string['config:quiz'] = 'Prueba';
$string['config:add'] = 'Agregar';
$string['config:add_course'] = 'Agregar Curso';
$string['config:add_course_for_save'] = 'A Salvar';
$string['config:import'] = 'Importar';
$string['config:no_courses'] = '¡Por favor, agregue un curso!';
$string['config:select_course'] = 'Seleccionar curso';
$string['config:select_quiz'] = 'Seleccionar prueba';
$string['config:require_for_quiz'] = 'Requirir la extensión E-Proctoring';
$string['config:no_settings'] = 'Visite la <a href="{$a}">Página de configuración</a> para configurar sus credenciales antes de continuar.';

// Navbar menu
$string['navbar_menu:settings'] = 'Configuraciones';
$string['navbar_menu:sessions'] = 'Sesiones';
$string['navbar_menu:lti'] = 'LTI';

// Sessions list
$string['sessions_list:title'] = 'Lista de Sesiones';
$string['sessions_list:no_sessions'] = 'No hay sesiones registradas';
$string['sessions_list:button'] = 'Ver los informes de E-Proctoring';
$string['sessions_list:id'] = 'Identificación';
$string['sessions_list:student'] = 'Estudiante';
$string['sessions_list:date'] = 'Fecha';
$string['sessions_list:incident_level'] = 'Nivel de Incidente';
$string['sessions_list:actions'] = 'Acciones';
$string['sessions_list:select_course_and_quiz'] = 'Seleccione el curso y la prueba a continuación para ver los informes';
$string['sessions_list:total_number'] = 'Total de Sesiones';
$string['sessions_list:view_reports'] = 'Ver los informes';
$string['sessions_list:no_quiz_enabled'] = 'No hay pruebas con E-Proctoring habilitado. Habilite al menos una en la página CONFIGURACIONES';
$string['sessions_list:reviewed'] = 'Revisada';
$string['sessions_list:filter'] = 'Filtro';
$string['sessions_list:search'] = 'Procurar';

// Session report
$string['session_report:session_details'] = 'Detalles de sesión';
$string['session_report:start_time'] = 'Hora de inicio';
$string['session_report:end_time'] = 'Hora de finalización';
$string['session_report:completed'] = 'Terminado';
$string['session_report:log'] = 'Registro';
$string['session_report:incident:low'] = 'Bajo';
$string['session_report:incident:medium'] = 'Medio';
$string['session_report:incident:high'] = 'Alto';
$string['session_report:incident:invalid'] = 'Inválida';
$string['session_report:screen_archive'] = 'Archivo de la pantalla';
$string['session_report:no_screens'] = 'No hay capturas de pantalla para esta sesión';
$string['session_report:no_logs'] = 'No hay eventos para esta sesión';
$string['session_report:hour'] = 'Hora';
$string['session_report:type'] = 'Tipo';
$string['session_report:video_archive'] = 'Archivo de Vídeos';
$string['session_report:no_videos'] = 'No hay vídeos para esta sesión';
$string['session_report:incident_level_changed'] = '¡Nivel de Incidente cambiado con éxito!';
$string['session_report:review_changed'] = '¡Revisión de sesión actualizada!';
$string['session_report:back_to_list'] = 'Volver a la lista';
$string['session_report:comments'] = 'Comentarios';
$string['session_report:session_updated'] = '¡Sesión actualizada!';

// Events
$string['EVENT_MULTIPLE_FACES_DETECTED'] = "Varias personas detectadas en la cámara";
$string['EVENT_NO_FACE_DETECTED'] = "Ningún usuario detectado";
$string['EVENT_NEW_TAB_WINDOW'] = "El usuario intentó abrir nuevas pestañas y/o nuevas ventanas";
$string['EVENT_START_STREAMING'] = "La transmisión de video comenzó";
$string['EVENT_STOP_STREAMING'] = "La transmisión de video se detuvo";
$string['EVENT_MORE_THAN_ONE_CAM'] = "Se detectaron varias cámaras";
$string['EVENT_MULTIPLE_DISPLAYS_DETECTED'] = "Se detectaron varias pantallas";
$string['EVENT_MOVE_FOCUS'] = "Se movió el foco fuera de la ventana de prueba";
$string['EVENT_CLOSED_WINDOW'] = "Navegador cerrado o pestaña/actualización de la página a través del navegador";
$string['EVENT_CLOSED_WINDOW_OR_TAB'] = "Navegador cerrado o pestaña/actualización de la página a través del teclado";
$string['EVENT_FINISH_SIMULATION'] = "Prueba completada con éxito";
$string['EVENT_START_SIMULATION'] = "Prueba iniciada";
$string['EVENT_TEST_PAUSED'] = "Prueba pausada";
$string['EVENT_TEST_RESUMED'] = "Prueba reanudada";
$string['EVENT_SUSPENDED_CAMERA'] = "Usuario/algún error suspendió la cámara";
$string['EVENT_GAZE_DETECTION'] = "El usuario apartó la mirada de la pantalla durante al menos 3 segundos";

// Error messages
$string['error:unable_list_sessions'] = 'No se pueden enumerar las sesiones. Verifique sus credenciales en la sección de CONFIGURACIONES.';
$string['error:unable_session_details'] = 'No es posible obtener los detalles de la sesión';
$string['error:unable_session_events'] = 'No es posible obtener los eventos de la sesión';
$string['error:general'] = 'Ocurrió un error: {$a}';

// Privacy API 
$string['privacy:metadata:quizaccess_edusynch:antifraud_api:firstname'] = 'Usamos el nombre para almacenar el nombre del estudiante en nuestra base de datos. Esto es para que los administradores puedan identificar mejor al estudiante.';
$string['privacy:metadata:quizaccess_edusynch:antifraud_api:lastname'] = 'Usamos apellido para almacenar el apellido del estudiante en nuestra base de datos. Esto es para que los administradores puedan identificar mejor al estudiante.';
$string['privacy:metadata:quizaccess_edusynch:antifraud_api:email'] = 'Usamos el correo electrónico para almacenar la dirección de correo electrónico del estudiante. Esta es la credencial principal de la cuenta del estudiante, ya que los administradores generalmente usan la dirección de correo electrónico como el identificador único principal del estudiante.';
$string['privacy:metadata:quizaccess_edusynch:antifraud_api'] = 'Usamos nuestro antifraud_api para determinar si el usuario intentó abrir nuevas pestañas, movió el foco fuera del navegador o realizó alguna otra acción que no está permitida por el complemento para evitar trampas.';
