<?php
/**
 *   A filter plus iterator that validates the data using the supplied filter
 **/
class DataFilterIterator extends FilterIterator
{
    private $keys;
    private $filter;
    private $callback;
    private $header;
    
    public function __construct(Iterator $iterator, $filter, $header)
    {
        parent::__construct($iterator);
        $this->filter = $filter;
        $this->header = $header;
        $this->keys   = array_flip($this->header);
    }
    
    //check if the iterator item is valid using the filter
    public function accept()
    {
        $data = $this->getInnerIterator()->current();
        
        $is_acceptable = true;
        
        if (is_array($this->filter)) {
            foreach ($this->filter as $key => $value) {
                if (array_key_exists('length', $value)) {
                    $data_item = strlen($data[$this->keys[$key]]);
                    $comp_data = $value['length'];
                } elseif (array_key_exists('value', $value)) {
                    $data_item = $data[$this->keys[$key]];
                    $comp_data = $value['value'];
                }
                
                if ($value['condition'] == '==' && !($data_item == $comp_data)) {
                    $is_acceptable = false;
                    break;
                } elseif ($value['condition'] == '>' && !($data_item > $comp_data)) {
                    $is_acceptable = false;
                    break;
                } elseif ($value['condition'] == '<' && !($data_item < $comp_data)) {
                    $is_acceptable = false;
                    break;
                }
                
            }
        }
        
        return $is_acceptable;
        
    }
}