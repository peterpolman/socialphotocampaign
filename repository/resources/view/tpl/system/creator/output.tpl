<pre><&#63;php
class {$pClassName} extends WCMS3_Db_Record
{literal}{{/literal}
	protected $table 		= '{$table}';
	protected $primary 		= '{$primary}';
	protected $tableFields		= array(
{foreach from=$fields item=field key=key name=fieldthing}
						'{$key}' => null{if $smarty.foreach.fieldthing.last != true},{/if}
								
{/foreach}
					);

	//Start of Setters
	//----------------
	
{foreach from=$fields item=field key=key}
	public function set{$field} ($value)
{literal}	{{/literal}
{literal}		$this->tableFields['{/literal}{$key}{literal}'] = $value;{/literal}
{literal}	}{/literal}

{/foreach}
	//Start of Getters
	//----------------
	
{foreach from=$fields item=field key=key}
	public function get{$field}()
{literal}	{{/literal}
{literal}		return $this->tableFields['{/literal}{$key}{literal}'];{/literal}
{literal}	}{/literal}

{/foreach}
{literal}}{/literal}
&#63;>
</pre>