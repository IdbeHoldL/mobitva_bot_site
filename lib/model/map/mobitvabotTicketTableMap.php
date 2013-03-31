<?php


/**
 * This class defines the structure of the 'mobitvabot_ticket' table.
 *
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 08/13/12 10:59:37
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class mobitvabotTicketTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.mobitvabotTicketTableMap';

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
		$this->setName('mobitvabot_ticket');
		$this->setPhpName('mobitvabotTicket');
		$this->setClassname('mobitvabotTicket');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addForeignKey('USER_ID', 'UserId', 'INTEGER', 'sf_guard_user', 'ID', true, null, null);
		$this->addForeignKey('TICKET_GROUP_ID', 'TicketGroupId', 'INTEGER', 'mobitvabot_ticket_group', 'ID', true, null, null);
		$this->addColumn('IS_NEW', 'IsNew', 'BOOLEAN', true, null, false);
		$this->addColumn('IS_PUBLIC', 'IsPublic', 'BOOLEAN', true, null, false);
		$this->addColumn('IS_CLOSED', 'IsClosed', 'BOOLEAN', true, null, false);
		$this->addColumn('NAME', 'Name', 'VARCHAR', true, 255, null);
		$this->addColumn('DESCRIPTION', 'Description', 'VARCHAR', true, 255, null);
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
    $this->addRelation('mobitvabotTicketGroup', 'mobitvabotTicketGroup', RelationMap::MANY_TO_ONE, array('ticket_group_id' => 'id', ), 'CASCADE', null);
    $this->addRelation('mobitvabotCrossTicketGroup', 'mobitvabotCrossTicketGroup', RelationMap::ONE_TO_MANY, array('id' => 'ticket_id', ), 'CASCADE', null);
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

} // mobitvabotTicketTableMap