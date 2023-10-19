<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_tbltasklog extends CI_Migration
{

    public function up()
    {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'logdetail' => array(
                'type' => 'TEXT',
                'null' => TRUE,
            ),
            'fktaskid' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'null' => TRUE,
            ),
            'fkstaffid' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'null' => TRUE,
            ),
            'adddate' => array(
                'type' => 'DATETIME',
                'null' => TRUE,
            ),
        ));

        $this->dbforge->add_key('id', TRUE);

        $this->dbforge->create_table('tbltasklog');
    }

    public function down()
    {
        $this->dbforge->drop_table('tbltasklog');
    }
}
