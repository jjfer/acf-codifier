<?php
/**
 * ACF Codifier conditional logic class.
 */

namespace Geniem\ACF;

/**
 * Class ConditionalLogicGroup
 */
class ConditionalLogicGroup {
    /**
     * The conditional logic rules
     *
     * @var array Conditional Logic rules to be stored
     */
    protected $rules = [];

    /**
     * Add a conditional logic rule.
     *
     * @param string  $field         The slug of the field to be compared to.
     * @param string  $operator      Operator to be used, either '==' or '!='.
     * @param boolean $value         Value to be used in comparison.
     * @throws \Geniem\ACF\Exception Throw error if given parameter is not valid.
     * @return self
     */
    public function add_rule( string $field, string $operator, bool $value ) {
        // Check for valid values for the parameter.
        if ( ! in_array( $operator, [ '==', '!=' ] ) ) {
            throw new \Geniem\ACF\Exception( 'Geniem\ACF\ConditionalRule: add_role() does not accept argument "' . $operator .'"' );
        }

        $this->rules[] = [ 'field' => $field, 'operator' => $operator, 'value' => (int) $value ];

        return $this;
    }

    /**
     * Get added conditional logic rules.
     *
     * @return array
     */
    public function get_rules() {
        return $this->rules;
    }
}