<?php

namespace Iridium\Components\Permissions\tests\units\RoleBased;

require_once __DIR__ . '/../../../vendor/autoload.php';

use atoum ,
    Iridium\Components\Permissions\RoleBased\Role as IrLRole;

class Role extends atoum
{

    public function testNewRole()
    {
        $role = new IrLRole( 'test' );
        $this->string( $role->getName() )
                ->isEqualTo( 'test' );
    }

    public function testNewRoleThrowsExceptionOnBadParameter()
    {
        $this->exception( function () {
                    new IrLRole( 12.65 );
                } )
                ->isInstanceOf( '\InvalidArgumentException' )
                ->hasMessage( 'role name must be a non-empty string' )
                ->exception( function () {
                    new IrLRole( '' );
                } )
                ->isInstanceOf( '\InvalidArgumentException' )
                ->hasMessage( 'role name must be a non-empty string' );
    }

    public function testHasPermissionReturnsFalseOnEmpty()
    {
        $role = new IrLRole( 'test' );
        $this->boolean( $role->hasPermission( 'test' ) )
                ->isFalse();
    }

    public function testGrant()
    {
        $role = new IrLRole( 'test' );
        $role->grant( new \mock\Iridium\Components\Permissions\RoleBased\Permission( 'testPermission' ) );

        $this->boolean( $role->hasPermission( 'testPermission' ) )
                ->isTrue();
    }

    public function testRevoke()
    {
        $role = new IrLRole( 'test' );
        $role->grant( new \mock\Iridium\Components\Permissions\RoleBased\Permission( 'testPermission' ) );
        $role->revoke( ('testPermission' ) );

        $this->boolean( $role->hasPermission( 'testPermission' ) )
                ->isFalse();
    }

    public function testRevokeThrowsExceptionOnUnknownIndex()
    {
        $role = new IrLRole( 'test' );
        $this->exception( function () use ($role) {
                    $role->revoke( 'wrongPermission' );
                } )
                ->isInstanceOf( '\OutOfBoundsException' )
                ->hasMessage( 'wrongPermission permission is not defined' );
    }

    public function testGetIterator()
    {
        $role = new IrLRole( 'test' );
        $role->grant( new \mock\Iridium\Components\Permissions\RoleBased\Permission( 'testPerm.first' ) )
                ->grant( new \mock\Iridium\Components\Permissions\RoleBased\Permission( 'testPerm.second' ) )
                ->grant( new \mock\Iridium\Components\Permissions\RoleBased\Permission( 'testPerm.third' ) );

        foreach ($role as $perm) {
            $this->object( $perm )
                    ->isInstanceOf( '\mock\Iridium\Components\Permissions\RoleBased\Permission' );
        }
    }

    public function testRoleSerialize()
    {
        $role = new IrLRole( 'test' );
        $role->grant( new \mock\Iridium\Components\Permissions\RoleBased\Permission( 'testPerm' ) );
        $sr   = serialize( $role );

        $role2 = unserialize( $sr );
        $this->object( $role2 )
                ->isInstanceOf( 'Iridium\Components\Permissions\RoleBased\Role' )
                ->boolean( $role2->hasPermission( 'testPerm' ) );
    }

}
