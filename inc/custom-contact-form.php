<?php  
/* Da de alta una seccion(menu) de 'Ajustes de menu' en el WP-Admin */
//https://codex.wordpress.org/Class_Reference/wpdb
//https://developer.wordpress.org/reference/classes/wpdb/

if(!function_exists('cinecode_contact_table')):
    function cinecode_contact_table(){
        global $wpdb; /*  */
        global $contact_table_version; /* variable global referencia a mi tabla */
        $contact_table_version = '1.0.0';
        $table = $wpdb->prefix . 'contact_form'; /* nombre de mi tabla concatenado prefigo de tablas */
        $charset_collate = $wpdb->get_charset_collate(); /* caracter charset de la tabla  */
        $sql = "
        CREATE TABLE $table (
            contact_id MEDIUMINT(9) NOT NULL AUTO_INCREMENT,
            name VARCHAR(50) NOT NULL,
            email VARCHAR(50) NOT NULL,
            subject VARCHAR(50) NOT NULL,
            comments LONGTEXT NOT NULL,
            contact_date DATETIME NOT NULL,
            PRIMARY KEY (contact_id)
        ) $charset_collate;
        ";
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';  
        dbDelta( $sql ); /* cada modificacion a bd wordpress se establece con dbDelta y pasamos codigo sql que ejecutaremos*/
        add_option( 'contact_table_version', $contact_table_version ); /* creamos opcion  para guardar version de mi tabla*/
    }
endif;
add_action('after_setup_theme','cinecode_contact_table'); 

if(!function_exists('cinecode_contact_form_menu')):
    function cinecode_contact_form_menu(){
        add_menu_page('Contacto', 'Contacto', 'administrator', 'contact_form','cinecode_contact_form_comments', 'dashicons-admin-id-alt',20);

        /* sub pagina */
        add_submenu_page('contact_form', 'Todos los contactos', 'Todos los contactos', 'administrator', 'contact_form_comments', 'cinecode_contact_form_comments');
    }
endif;
add_action('admin_menu','cinecode_contact_form_menu');

if(!function_exists('cinecode_contact_form_comments')): /* formulario en admin para cambiar texto en el footer */
    function cinecode_contact_form_comments(){ 
             
    ?> 
        <div class="wrap">
            <h1><?php  _e('Comentarios de la página de coantacto','cinecode'); ?></h1>
            <table class="wp-list-table widefat striped">
                <thead>
                    <tr>
                        <th class="manage-column"><?php _e('Id', 'cinecode'); ?></th>
                        <th class="manage-column"><?php _e('Nombre', 'cinecode'); ?></th>
                        <th class="manage-column"><?php _e('Email', 'cinecode'); ?></th>
                        <th class="manage-column"><?php _e('Asunto', 'cinecode'); ?></th>
                        <th class="manage-column"><?php _e('Comentarios', 'cinecode'); ?></th>
                        <th class="manage-column"><?php _e('Fecha', 'cinecode'); ?></th>
                        <th class="manage-column"><?php _e('Eliminar', 'cinecode'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <td>valor 1</td>
                    <td>valor 2</td>
                    <td>valor 3</td>
                    <td>valor 4</td>
                    <td>valor 5</td>
                    <td>valor 6</td>
                    <td>valor 7</td>
                </tbody>
            </table>
        </div>  
    <?php
    }     
endif;

//https://codex.wordpress.org/Shortcode_API
//https://codex.wordpress.org/Function_Reference/add_shortcode
if ( !function_exists('cinecode_contact_form')):
    function cinecode_contact_form ($atts) {
  ?>
      <form class="ContactForm" method="POST">
       <legend><?php echo $atts['title']; ?></legend>
       <input type="text" name="name" placeholder="Escribe tu nombre">
       <input type="email" name="email" placeholder="Escribe tu email">
       <input type="text" name="subject" placeholder="Asunto a tratar">
        <textarea name="comments" cols="50" rows="5" placeholder="Escribe tus comentarios"></textarea>
        <input type="submit" value="Enviar">
        <input type="hidden" name="send_contact_form" value="1">
      </form>
    <?php
    }
  endif;
  add_shortcode( 'contact_form', 'cinecode_contact_form' ); /*  */

?>