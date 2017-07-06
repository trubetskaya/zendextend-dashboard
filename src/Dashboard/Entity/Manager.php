<?php

namespace Dashboard\Entity {

    use ZfcUser\Entity\UserInterface;
    use ZfcRbac\Identity\IdentityInterface;
    use ZfcUserDoctrineORM\Entity\User as ZfcUser;

    use Doctrine\ORM\Mapping as ORM;
    use Doctrine\Common\Collections\ArrayCollection;
    use Doctrine\Common\Collections\Collection;

    /**
     * @ORM\Entity
     * @ORM\Table(name="managers")
     */
    class Manager extends ZfcUser implements
        IdentityInterface,
        UserInterface
    {
        /**
         * @var int
         *
         * @ORM\Id
         * @ORM\Column(type="integer")
         * @ORM\GeneratedValue(strategy="AUTO")
         */
        protected $id;
        
        /**
         * @var string
         *
         * @ORM\Column(unique=true)
         */
        protected $username;

        /**
         * @var string
         *
         * @ORM\Column(unique=true)
         */
        protected $email;

        /**
         * @var string
         *
         * @ORM\Column(name="display_name", length=50, nullable=true)
         */
        protected $displayName;

        /**
         * @var string
         *
         * @ORM\Column(length=128)
         */
        protected $password;

        /**
         * @var int
         *
         * @ORM\Column(type="smallint", length=5, nullable=true)
         */
        protected $state;

        /**
         * @var Role[]|ArrayCollection
         *
         * @ORM\ManyToMany(targetEntity="Role")
         */
        protected $roles;

        /**
         * Manager constructor.
         */
        public function __construct()
        {
            $this->roles = new ArrayCollection();
        }

        /**
         * Get id.
         *
         * @return int
         */
        public function getId()
        {
            return $this->id;
        }

        /**
         * Set id
         *
         * @param int $id
         * @return $this
         */
        public function setId($id)
        {
            $this->id = $id;
            return $this;
        }

        /**
         * Get username.
         *
         * @return string
         */
        public function getUsername()
        {
            return $this->username;
        }

        /**
         * Set username.
         *
         * @param string $username
         * @return $this
         */
        public function setUsername($username)
        {
            $this->username = $username;
            return $this;
        }

        /**
         * Get email.
         *
         * @return string
         */
        public function getEmail()
        {
            return $this->email;
        }

        /**
         * Set email.
         *
         * @param string $email
         * @return $this
         */
        public function setEmail($email)
        {
            $this->email = $email;
            return $this;
        }

        /**
         * Get display name.
         *
         * @return string
         */
        public function getDisplayName()
        {
            return $this->displayName;
        }

        /**
         * Set displayName.
         *
         * @param string $displayName
         * @return $this
         */
        public function setDisplayName($displayName)
        {
            $this->displayName = strval($displayName);
            return $this;
        }

        /**
         * Get password.
         *
         * @return string
         */
        public function getPassword()
        {
            return $this->password;
        }

        /**
         * Set password.
         *
         * @param string $password
         * @return $this
         */
        public function setPassword($password)
        {
            $this->password = strval($password);
            return $this;
        }

        /**
         * Get state.
         *
         * @return int
         */
        public function getState()
        {
            return $this->state;
        }

        /**
         * Set state.
         *
         * @param int $state
         * @return $this
         */
        public function setState($state)
        {
            $this->state = $state;
            return $this;
        }

        /**
         * Get roles
         * @return Role[]
         */
        public function getRoles()
        {
            return $this->roles->toArray();
        }

        /**
         * Set the list of roles
         *
         * @param Collection $roles
         * @return $this
         */
        public function setRoles(Collection $roles)
        {
            $this->roles->clear();
            foreach ($roles as $role) {
                $this->roles->add($role);
            }

            return $this;
        }

        /**
         * Add one role to roles list
         * @param Role $role
         * @return $this
         */
        public function addRole(Role $role)
        {
            $this->roles->add($role);
            return $this;
        }
    }
}
