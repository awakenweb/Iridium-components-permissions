<?php

/*
 * The MIT License
 *
 * Copyright 2013 Mathieu.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace Iridium\Components\Permissions\RoleBased;

class RoleBased implements \IteratorAggregate
{

    protected $roles = array();

    /**
     * add a role to the list of identified roles
     *
     * @param  \Iridium\Components\Permissions\RoleBased\Role      $role
     * @return \Iridium\Components\Permissions\RoleBased\RoleBased
     */
    public function addRole(Role $role)
    {
        $this->roles[ $role->getName() ] = $role;

        return $this;
    }

    /**
     * get a role identified by its name
     *
     * @param  string                $rolename
     * @return Rolebased\Role
     * @throws \OutOfBoundsException
     */
    public function getRole($rolename)
    {
        if ( isset( $this->roles[ $rolename ] ) ) {
            return $this->roles[ $rolename ];
        }
        throw new \OutOfBoundsException( "$rolename role is not defined" );
    }

    /**
     * check if a role is granted a specific permission identified by their
     * respective names
     *
     * @param  type    $roleName
     * @param  type    $permissionName
     * @return boolean
     */
    public function isAllowed($roleName , $permissionName)
    {
        if ( isset( $this->roles[ $roleName ] ) ) {
            return $this->roles[ $roleName ]->hasPermission( $permissionName );
        }

        return false;
    }

    /**
     *
     * @return array
     */
    public function __sleep()
    {
        return array( 'roles' );
    }

    /**
     *
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator( $this->roles );
    }

}
