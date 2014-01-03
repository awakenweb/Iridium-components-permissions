<?php

namespace Iridium\Components\Permissions\tests\units\RoleBased;

require_once __DIR__ . '/../../../vendor/autoload.php';

use atoum ,
    Iridium\Components\Permissions\RoleBased\RoleBased as IrLRoleBased;

class RoleBased extends atoum
{

    public function testNewRole()
    {
        $rb = new IrLRoleBased();

        $role = new \mock\Iridium\Components\Permissions\RoleBased\Role( 'test' );
        $rb->addRole( $role );

        $this->object( $rb->getRole( 'test' ) )
                ->isInstanceOf( '\Iridium\Components\Permissions\RoleBased\Role' )
                ->exception( function () use ($rb) {
                    $rb->getRole( 'randomRole' );
                } )
                ->isInstanceOf( '\OutOfBoundsException' );
    }

    public function testNewRoleWithPermissions()
    {
        $rb   = new IrLRoleBased();
        $role = new \mock\Iridium\Components\Permissions\RoleBased\Role( 'test' );
        $role->grant( new \mock\Iridium\Components\Permissions\RoleBased\Permission( 'testPerm' ) );
        $rb->addRole( $role );

        $this->boolean( $rb->isAllowed( 'test' , 'testPerm' ) )
                ->isTrue()
                ->boolean( $rb->isAllowed( 'randomRole' , 'randomPerm' ) )
                ->isFalse();

        $this->object($rb->getIterator())
                ->isInstanceOf('\ArrayIterator');
    }

    public function testRoleBasedSerialize()
    {
        $rb   = new IrLRoleBased();
        $role = new \mock\Iridium\Components\Permissions\RoleBased\Role( 'test' );
        $role->grant( new \mock\Iridium\Components\Permissions\RoleBased\Permission( 'testPerm' ) );
        $rb->addRole( $role );

        $sr  = serialize( $rb );
        $rb2 = unserialize( $sr );
        $this->object( $rb2 )
                ->isInstanceOf( '\Iridium\Components\Permissions\RoleBased\RoleBased' )
                ->boolean( $rb2->isAllowed( 'test' , 'testPerm' ) )
                ->isTrue()
                ->boolean( $rb->isAllowed( 'randomRole' , 'randomPerm' ) )
                ->isFalse();
    }

}
