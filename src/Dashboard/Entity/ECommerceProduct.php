<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 03.07.14
 * Time: 23:00
 */

namespace Dashboard\Entity {

    use Doctrine\ORM\Mapping as ORM;
    use Lib\Entity\Currency;
    use Lib\Entity\Document;
    use Zend\Form\Annotation as Form;
    use Doctrine\Common\Collections\ArrayCollection;


    /**
     * Class Document
     * @package Commerce\Entity
     *
     * @ORM\Entity
     * @ORM\Table(name="ecommerce")
     * @ORM\HasLifecycleCallbacks
     *
     * @Form\Name("ecommerce-form")
     */
    class ECommerceProduct extends Document
    {
        use ECommerceProductTrait;

        /**
         * @var string
         * @Form\Type("Select")
         * @Form\Flags({"priority": 49})
         * @Form\Required(true)
         * @Form\Options({
         *      "label"         : "Transmission",
         *      "allow_empty"   : false,
         *      "value_options" : {
         *          1: "Auto",
         *          2: "Adaptive",
         *          3: "Variator",
         *          4: "Manual",
         *          5: "Tiptronic"
         *      }
         * })
         * @Form\Attributes({
         *      "id": "transmission",
         *      "class": "form-control select2_single",
         *      "data-parsley-required": "true",
         *      "data-parsley-required-message": "Fuel type required",
         * })
         * @ORM\Column(name="transmission", type="smallint")
         **/
        protected $transmission;

        /**
         * @var ArrayCollection
         * @Form\Type("Select")
         * @Form\Flags({"priority": 48})
         * @Form\Options({
         *      "label"         : "Fuel type",
         *      "allow_empty"   : false,
         *      "value_options" : {
         *          1: "Petrol",
         *          2: "Gas",
         *          3: "Gas/Petrol",
         *          4: "Electric",
         *          5: "Hybrid",
         *          6: "Diesel"
         *      }
         * })
         * @Form\Attributes({
         *      "id": "fuel",
         *      "data-parsley-required"          : "true",
         *      "data-parsley-required-message"  : "Fuel type required",
         *      "class"                          : "form-control select2_single"
         * })
         * @ORM\Column(name="fuel", type="smallint", nullable=false)
         **/
        protected $fuel;

        /**
         * @var float
         * @Form\Type("Range")
         * @Form\Flags({"priority": 47})
         * @Form\Options({
         *      "label": "Engine volume",
         *      "label_attributes": {
         *          "class": "slider-label"
         *      }
         * })
         * @Form\Attributes({
         *      "data-parsley-required"          : "true",
         *      "data-parsley-required-message"  : "Engine volume cant be empty",
         *      "data-parsley-type"              : "number",
         *
         *      "data-slider-id"                : "engine-volume-slider",
         *      "data-slider-tooltip"           : "always",
         *      "data-slider-tooltip-position"  : "bottom",
         *      "data-slider-step"              : 0.10,
         *      "data-slider-max"               : 12.00,
         *      "data-slider-min"               : 0.10,
         *      "data-slider-precision"         : 1,
         *
         *      "id"    : "engine-volume",
         *      "class" : "form-control slider-element",
         * })
         * @ORM\Column(name="volume", type="decimal", precision=20, scale=2, nullable=false, unique=false)
         */
        protected $volume;

        /**
         * @var float
         * @Form\Type("Number")
         * @Form\Flags({"priority": 46})
         * @Form\Options({"label": "Mileage", "id": "mileage-range"})
         * @Form\Attributes({
         *      "data-parsley-required"             : "true",
         *      "data-parsley-required-message"     : "Mileage cant be empty",
         *      "data-parsley-type"                 : "number",
         *
         *      "class"     : "form-control",
         *      "id"        : "mileage-range",
         *      "min"       : 0
         * })
         * @ORM\Column(name="mileage", type="integer", nullable=false, unique=false)
         */
        protected $mileage;

        /**
         * @var int
         * @Form\Type("Number")
         * @Form\Flags({"priority": 45})
         * @Form\Options({"label": "Registration date"})
         * @Form\Attributes({
         *      "id": "registration-date",
         *      "data-parsley-required"          : "true",
         *      "data-parsley-required-message"  : "Registration date value must be digit",
         *      "data-parsley-type"              : "number",
         *
         *      "class"     : "form-control",
         *      "min"       : 1930
         * })
         * @ORM\Column(name="registration_date", type="smallint", nullable=false, options={"default": 0, "comment": "Registration year"})
         */
        protected $registrationDate;

        /**
         * @var Currency
         * @Form\Type("\DoctrineORMModule\Form\Element\EntitySelect")
         * @Form\Flags({"priority": 43})
         * @Form\Options({
         *      "allow_empty"   : false,
         *      "label"         : "Currency",
         *      "target_class"  : Lib\Entity\Currency::class,
         *      "property"      : "name",
         *      "is_method"     : true,
         *      "find_method"   : {
         *          "name"      : "findBy",
         *          "params"    : {
         *              "criteria"  : { "active" : 1 },
         *              "orderBy"   : { "index": "ASC" }
         *          }
         *      }
         * })
         * @Form\Attributes({
         *      "id": "currency",
         *      "data-parsley-required": "true",
         *      "data-parsley-required-message": "Currency required",
         *      "class": "form-control select2_single"
         * })
         *
         * @ORM\ManyToOne(targetEntity=Lib\Entity\Currency::class)
         * @ORM\JoinColumn(name="currency_id", referencedColumnName="id", nullable=false)
         **/
        protected $currency;

        /**
         * Constructor
         */
        public function __construct()
        {
            parent::__construct();
        }

        /**
         * Set currency
         * @return Currency
         */
        public function getCurrency()
        {
            return $this->currency;
        }

        /**
         * Set currency
         * @param Currency $currency
         * @return $this
         */
        public function setCurrency(Currency $currency)
        {
            $this->currency = $currency;
            return $this;
        }

        /**
         * Set transmission
         * @return string
         */
        public function getTransmission()
        {
            return $this->transmission;
        }

        /**
         * Set transmission
         * @param string $transmission
         * @return $this
         */
        public function setTransmission($transmission)
        {
            $this->transmission = $transmission;
            return $this;
        }

        /**
         * Set fuel
         * @return ArrayCollection
         */
        public function getFuel()
        {
            return $this->fuel;
        }

        /**
         * Set fuel
         * @param ArrayCollection $fuel
         * @return $this
         */
        public function setFuel($fuel)
        {
            $this->fuel = $fuel;
            return $this;
        }

        /**
         * Get volume
         * @return float
         */
        public function getVolume()
        {
            return $this->volume;
        }

        /**
         * Set volume
         * @param float $volume
         * @return $this
         */
        public function setVolume($volume)
        {
            $this->volume = $volume;
            return $this;
        }

        /**
         * Get mileage
         * @return float
         */
        public function getMileage()
        {
            return $this->mileage;
        }

        /**
         * Set mileage
         * @param float $mileage
         * @return $this
         */
        public function setMileage($mileage)
        {
            $this->mileage = $mileage;
            return $this;
        }

        /**
         * Get registrationDate
         * @return int
         */
        public function getRegistrationDate()
        {
            return $this->registrationDate;
        }

        /**
         * Get registrationDate
         * @param int $registrationDate
         * @return $this
         */
        public function setRegistrationDate($registrationDate)
        {
            $this->registrationDate = $registrationDate;
            return $this;
        }

        /**
         * Function jsonSerialize
         * @return array
         */
        function jsonSerialize()
        {
            return [
                "DT_RowId" => "row-{$this->getId()}",
                "doc" => [
                    "name" => $this->getName(),
                    "description" => $this->getDescription(),
                    "updated" => $this->getUpdated()->format(\DateTime::W3C),
                    "preview" => $this->preview(),
                    "price" => $this->getAmount(),
                    "index" => $this->getIndex(),
                    "condition" => [
                        "id" => $this->getCondition()->getId(),
                        "name" => $this->getCondition()->getName()
                    ]
                ],
                "links" => [
                    "edit" => '/dashboard/commerce/edit/' . $this->getId(),
                    "drop" => '/dashboard/commerce/remove/' . $this->getId(),
                ]
            ];
        }
    }
}

