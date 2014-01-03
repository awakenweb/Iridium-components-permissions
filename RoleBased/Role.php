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

class Role implements \IteratorAggregate
{

    /**
     *
     * @var array
     */
    protected $permissions = array();

    /**
     *
     * @var string
     */
    protected $name;

    /**
     * define a new role identified by its name
     *
     * @param  string                    $name
     * @throws \InvalidArgumentException
     */
    public function __construct($name)
    {
        if ( ! is_string( $name ) || $name === '' ) {
            throw new \InvalidArgumentException( 'role name must be a non-empty string' );
        }
        $this->name = $name;
    }

    /**
     * get the name of the role
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * grant a specific permission
     *
     * @param  \Iridium\Components\Permissions\RoleBased\Permission $permission
     * @return \Iridium\Components\Permissions\RoleBased\Role
     */
    public function grant(Permission $permission)
    {
        $this->permissions[ $permission->getName() ] = $permission;

        return $this;
    }

    /**
     * revoke a specific permission identified by its name
     *
     * @param  string                                         $permissionname
     * @return \Iridium\Components\Permissions\RoleBased\Role
     * @throws \OutOfBoundsException
     */
    public function revoke($permissionname)
    {
        if ( isset( $this->permissions[ $permissionname ] ) ) {
            unset( $this->permissions[ $permissionname ] );

            return $this;
        }
        throw new \OutOfBoundsException( "$permissionname permission is not defined" );
    }

    /**
     * check if the role has a specific permission
     *
     * @param  string  $name
     * @return boolean
     */
    public function hasPermission($name)
    {
        if ( isset( $this->permissions[ $name ] ) ) {
            return true;
        }

        return false;
    }

    /**
     *
     * @return array
     */
    public function __sleep()
    {
        return array( 'name' , 'permissions' );
    }

    /**
     *
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator( $this->permissions );
    }

}
