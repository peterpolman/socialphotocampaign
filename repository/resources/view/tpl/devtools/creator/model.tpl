{literal}<?php{/literal}
class {$Classname}_db extends WE_Db_Record
{literal}{{/literal}
	protected $table 			= '{$table}';
	protected $primary 			= {$primary};
	{if isset($autoIncrement)}protected $autoIncrement	= '{$autoIncrement}';{/if}
	
	protected $tableFields		= array(
{foreach from=$fields item=field key=key name=fieldthing}
						'{$key}' => null{if $smarty.foreach.fieldthing.last != true},{/if}
								
{/foreach}
	);
					
	protected $objectAwareness	= array(
{foreach from=$fields item=field key=key name=fieldthing}
{if key_exists($key,$aConstraints)}
						'{$key}' => '{$aConstraints.$key}'{if $smarty.foreach.fieldthing.last != true},{/if}
{else}
						'{$key}' => null{if $smarty.foreach.fieldthing.last != true},{/if}
{/if}	
{/foreach}
	);
	
	protected $OABuffer	= array(
{foreach from=$fields item=field key=key name=fieldthing}
						'{$key}' => null{if $smarty.foreach.fieldthing.last != true},{/if}

{/foreach}
	);
					
	protected $validation_model	= array(
{foreach from=$validate item=valrule key=key name=fieldthing}
						'{$key}' => array(
{foreach from=$valrule item=value key=option name=valthing}
{if is_array($value)}
										'{$option}'=>array(
{foreach from=$value item=subvalue key=suboption name=subvalthing}
											'{$suboption}'=>{$subvalue}{if $smarty.foreach.subvalthing.last != true},{/if}

{/foreach}
											){if $smarty.foreach.valthing.last != true},{/if}
											
{else}
										'{$option}'=>{$value}{if $smarty.foreach.valthing.last != true},{/if}

{/if}
{/foreach}
										){if $smarty.foreach.fieldthing.last != true},{/if}
										
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
{if key_exists($key,$aConstraints)}
	public function get{$field}($model = false)
{else}
	public function get{$field}()
{/if}
{literal}	{{/literal}
{if key_exists($key,$aConstraints)}
{literal}		if ($model == true) {{/literal}
{literal}			return $this->getObjectAware('{/literal}{$key}{literal}');{/literal}
{literal}		}{/literal}
{/if}
{literal}		return $this->tableFields['{/literal}{$key}{literal}'];{/literal}
{literal}	}{/literal}

{/foreach}
{literal}}
?>{/literal}