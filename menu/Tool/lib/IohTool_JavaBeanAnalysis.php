<?php

class IohTool_JavaBeanAnalysis
{

    private $_class_content = array();

    public function setClass($class_name, $class_type)
    {
        $cls_obj = new ClassObject();
        $cls_obj->setClassName($class_name);
        $cls_obj->setClassType($class_type);
        $this->_class_content[$class_name] = $cls_obj;
    }

    public function setClassProperty($class_name, $property_name, $property_datatype, $property_is_list)
    {
        $this->_class_content[$class_name]->setClassProperty($property_name, $property_datatype, $property_is_list);
    }

    public function hasClass($class_name)
    {
        return isset($this->_class_content[$class_name]);
    }

    public function getClassList()
    {
        return $this->_class_content;
    }
}

class ClassObject
{

    private $_class_name;

    private $_class_type = false;

    private $_class_property = array();

    public function setClassName($class_name)
    {
        $this->_class_name = $class_name;
    }

    public function getClassName()
    {
        return $this->_class_name;
    }

    public function setClassType($class_type)
    {
        $this->_class_type = $class_type;
    }

    public function getClassType()
    {
        return $this->_class_type;
    }

    public function setClassProperty($property_name, $property_datatype, $property_is_list)
    {
        $prop_obj = new PropertyObject();
        $prop_obj->setPropertyName($property_name);
        $prop_obj->setPropertyDatatype($property_datatype);
        $prop_obj->setPropertyIsList($property_is_list);
        $this->_class_property[$property_name] = $prop_obj;
    }

    public function getClassProperty()
    {
        return $this->_class_property;
    }
}

class PropertyObject
{

    private $_property_name;

    private $_property_datatype;

    private $_property_is_list = false;

    public function setPropertyName($property_name)
    {
        $this->_property_name = $property_name;
    }

    public function getPropertyName()
    {
        return $this->_property_name;
    }

    public function setPropertyDatatype($property_datatype)
    {
        $this->_property_datatype = $property_datatype;
    }

    public function getPropertyDatatype()
    {
        return $this->_property_datatype;
    }

    public function setPropertyIsList($property_is_list)
    {
        $this->_property_is_list = $property_is_list;
    }

    public function getPropertyIsList()
    {
        return $this->_property_is_list;
    }
}
?>