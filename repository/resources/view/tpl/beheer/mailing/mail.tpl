<p>Beste {if isset($ontvanger)}{$ontvanger->getFirst_name()} {$ontvanger->getLast_name()}{else}&lt;naam&gt;{/if},</p>
<p>De winnaar van deze maand is {$entry->getFirst_name()} {$entry->getLast_name()} met onderstaande foto.</p>
<p><img src="{$secure_root}files/medium/{$entry->getFilename()}"/></p>
<p>{$text}</p>
<p>Groetjes!<br/>
De website</p>