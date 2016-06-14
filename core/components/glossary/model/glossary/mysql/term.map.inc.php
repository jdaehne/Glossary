<?php
/**
 * @package glossary
 */
$xpdo_meta_map['Term']= array (
  'package' => 'glossary',
  'version' => '1.1',
  'table' => 'glossary',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'term' => '',
    'explanation' => '',
    'modified' => NULL,
    'modified_by' => 0,
  ),
  'fieldMeta' => 
  array (
    'term' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'explanation' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'modified' => 
    array (
      'dbtype' => 'timestamp',
      'phptype' => 'timestamp',
      'null' => true,
      'default' => NULL,
      'attributes' => 'ON UPDATE CURRENT_TIMESTAMP',
    ),
    'modified_by' => 
    array (
      'dbtype' => 'int',
      'precision' => '11',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
    ),
  ),
  'aggregates' => 
  array (
    'Editor' => 
    array (
      'class' => 'modUser',
      'local' => 'modified_by',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
  ),
);
