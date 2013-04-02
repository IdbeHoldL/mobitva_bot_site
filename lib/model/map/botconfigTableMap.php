<?php


/**
 * This class defines the structure of the 'botconfig' table.
 *
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 03/31/13 20:17:31
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class botconfigTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.botconfigTableMap';

	/**
	 * Initialize the table attributes, columns and validators
	 * Relations are not initialized by this method since they are lazy loaded
	 *
	 * @return     void
	 * @throws     PropelException
	 */
	public function initialize()
	{
	  // attributes
		$this->setName('botconfig');
		$this->setPhpName('botconfig');
		$this->setClassname('botconfig');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addForeignKey('USER_ID', 'UserId', 'INTEGER', 'sf_guard_user', 'ID', true, null, null);
		$this->addColumn('NAME', 'Name', 'VARCHAR', true, 255, null);
		$this->addColumn('DESCRIPTION', 'Description', 'LONGVARCHAR', true, null, null);
		$this->addColumn('BODY', 'Body', 'LONGVARCHAR', true, null, null);
		$this->addColumn('PRICE', 'Price', 'INTEGER', false, null, 0);
		$this->addColumn('PRICE_KOEF', 'PriceKoef', 'INTEGER', false, null, 0);
		$this->addColumn('WEIGHT', 'Weight', 'INTEGER', false, null, 0);
		$this->addColumn('IS_APPROVED', 'IsApproved', 'BOOLEAN', false, null, false);
		$this->addColumn('IS_GLOBAL', 'IsGlobal', 'BOOLEAN', false, null, false);
		$this->addColumn('IS_EDITABLE', 'IsEditable', 'BOOLEAN', false, null, true);
		$this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
		$this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('sfGuardUser', 'sfGuardUser', RelationMap::MANY_TO_ONE, array('user_id' => 'id', ), 'CASCADE', null);
    $this->addRelation('botconfigRelationsRelatedByBotconfigId', 'botconfigRelations', RelationMap::ONE_TO_MANY, array('id' => 'botconfig_id', ), 'CASCADE', null);
    $this->addRelation('botconfigRelationsRelatedByParentBotconfigId', 'botconfigRelations', RelationMap::ONE_TO_MANY, array('id' => 'parent_botconfig_id', ), 'CASCADE', null);
    $this->addRelation('crosConfigCategory', 'crosConfigCategory', RelationMap::ONE_TO_MANY, array('id' => 'botconfig_id', ), 'CASCADE', null);
    $this->addRelation('crosUserConfig', 'crosUserConfig', RelationMap::ONE_TO_MANY, array('id' => 'botconfig_id', ), 'CASCADE', null);
	} // buildRelations()

	/**
	 * 
	 * Gets the list of behaviors registered for this table
	 * 
	 * @return array Associative array (name => parameters) of behaviors
	 */
	public function getBehaviors()
	{
		return array(
			'symfony' => array('form' => 'true', 'filter' => 'true', ),
			'symfony_behaviors' => array(),
			'symfony_timestampable' => array('create_column' => 'created_at', 'update_column' => 'updated_at', ),
		);
	} // getBehaviors()

} // botconfigTableMap
