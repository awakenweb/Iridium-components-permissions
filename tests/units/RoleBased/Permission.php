<?php

namespace Iridium\Components\Permissions\tests\units\RoleBased;

require_once __DIR__ . '/../../../vendor/autoload.php';

use atoum ,
    Iridium\Components\Permissions\RoleBased\Permission as IrLPermission;

class Permission extends atoum
{

    public function testNewPermission()
    {
        $permission = new IrLPermission( 'test' );
        $this->string( $permission->getName() )
                ->isEqualTo( 'test' );
    }

    public function testNewPermissionThrowsExceptionOnBadParameter()
    {
        $this->exception( function () {
                    new IrLPermission( 12.65 );
                } )
                ->isInstanceOf( '\InvalidArgumentException' )
                ->hasMessage( 'permission name must be a non-empty string' )
                ->exception( function () {
                    new IrLPermission( '' );
                } )
                ->isInstanceOf( '\InvalidArgumentException' )
                ->hasMessage( 'permission name must be a non-empty string' );
    }

    public function testPermissionSerialize()
    {
        $permission = new IrLPermission( 'test' );
        $sr         = serialize( $permission );

        $perm2 = unserialize( $sr );
        $this->object( $perm2 )
                ->isInstanceOf( 'Iridium\Components\Permissions\RoleBased\Permission' );
    }

}
