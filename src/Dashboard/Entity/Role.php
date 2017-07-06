<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license.
 */


namespace Dashboard\Entity {

    use Doctrine\ORM\Mapping as ORM;
    use Doctrine\Common\Collections\ArrayCollection;
    use Rbac\Role\HierarchicalRoleInterface;

    /**
     * @ORM\Entity
     * @ORM\Table(name="roles")
     */
    class Role implements
        HierarchicalRoleInterface
    {
        /**
         * @var int|null
         *
         * @ORM\Id
         * @ORM\Column(type="integer")
         * @ORM\GeneratedValue(strategy="AUTO")
         */
        protected $id;

        /**
         * @var string
         *
         * @ORM\Column(type="string", length=48, unique=true)
         */
        protected $name;

        /**
         * @var Role[]|ArrayCollection
         *
         * @ORM\ManyToMany(targetEntity="Role")
         */
        protected $children;

        /**
         * @var Permission[]|ArrayCollection
         *
         * @ORM\ManyToMany(targetEntity="Permission", indexBy="name", fetch="EAGER")
         */
        protected $permissions;

        /**
         * Init the Doctrine collection
         */
        public function __construct()
        {
            $this->children = new ArrayCollection();
            $this->permissions = new ArrayCollection();
        }

        /**
         * Get the role identifier
         *
         * @return int
         */
        public function getId()
        {
            return $this->id;
        }

        /**
         * Set the role name
         *
         * @param  string $name
         * @return $this
         */
        public function setName($name)
        {
            $this->name = strval($name);
            return $this;
        }

        /**
         * Get the role name
         *
         * @return string
         */
        public function getName()
        {
            return $this->name;
        }

        /**
         * Add child role
         *
         * @param HierarchicalRoleInterface $child
         * @return $this
         */
        public function addChild(HierarchicalRoleInterface $child)
        {
            $this->children->add($child);
            return $this;
        }

        /**
         * Add permission
         *
         * @param Permission|string $permission
         * @return $this
         */
        public function addPermission($permission)
        {
            if (is_string($permission)) {
                $permission = new Permission($permission);
            }

            $this->permissions[strval($permission)] = $permission;
            return $this;
        }

        /**
         * Function hasPermission
         *
         * @param string $permission
         * @return bool
         */
        public function hasPermission($permission)
        {
            // This can be a performance problem if your role has a lot of permissions. Please refer
            // to the cookbook to an elegant way to solve this issue

            return isset($this->permissions[strval($permission)]);
        }

        /**
         * Get child roles
         * @return Role[]|ArrayCollection
         */
        public function getChildren()
        {
            return $this->children;
        }

        /**
         * Has child roles
         * @return bool
         */
        public function hasChildren()
        {
            return !$this->children->isEmpty();
        }
    }
}