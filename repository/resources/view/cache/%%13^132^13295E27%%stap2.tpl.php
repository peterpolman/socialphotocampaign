<?php /* Smarty version 2.6.26, created on 2013-04-09 13:28:31
         compiled from front/inzendingen/stap2.tpl */ ?>
	<section id="content">
		<div class="wrapper">
			<div class="content">
				<form action="" method="post">
					<div class="col">
						<h2>Jouw gegevens</h2>
						<table>
							<tr>
								<td>Voornaam: </td><td><input type="text" name="firstname" value="<?php if (isset ( $this->_tpl_vars['firstname'] )): ?><?php echo $this->_tpl_vars['firstname']; ?>
<?php endif; ?>"/></td>
							</tr>
							<tr>
								<td>Achternaam: </td><td><input type="text" name="lastname" value="<?php if (isset ( $this->_tpl_vars['lastname'] )): ?><?php echo $this->_tpl_vars['lastname']; ?>
<?php endif; ?>"/></td>
							</tr>
							<tr>
								<td>E-mail: </td><td><input type="text" name="email" value="<?php if (isset ( $this->_tpl_vars['email'] )): ?><?php echo $this->_tpl_vars['email']; ?>
<?php endif; ?>"/></td>
							</tr>
							<tr>
								<td>Straat: </td><td><input type="text" name="streetname" value="<?php if (isset ( $this->_tpl_vars['streetname'] )): ?><?php echo $this->_tpl_vars['streetname']; ?>
<?php endif; ?>"/></td>
							</tr>
							<tr>
								<td>Huisnummer: </td><td><input type="text" name="streetnumber" value="<?php if (isset ( $this->_tpl_vars['streetnumber'] )): ?><?php echo $this->_tpl_vars['streetnumber']; ?>
<?php endif; ?>"/></td>
							</tr>
							<tr>
								<td>Postcode: </td><td><input type="text" name="postalcode" value="<?php if (isset ( $this->_tpl_vars['postalcode'] )): ?><?php echo $this->_tpl_vars['postalcode']; ?>
<?php endif; ?>"/></td>
							</tr>
							<tr>
								<td>Woonplaats: </td><td><input type="text" name="place" value="<?php if (isset ( $this->_tpl_vars['place'] )): ?><?php echo $this->_tpl_vars['place']; ?>
<?php endif; ?>"/></td>
							</tr>
						</table>
					</div>
					<div class="col">						
						<h2>Voorwaarden</h2>
						<div class="voorwaarden">
							•	Voorwaarden actie moeten duidelijk op onze site en op de site www.opknappertjenodig.nl staan
•	Bij uploaden keuken krijgt klant bevestigingsmail met unieke code..(opmaak mail nog afstemmen)
•	Deze code is € 25,- waard bij een besteding in de webshop of in een winkel
•	Deze € 25,- moet binnen 2 maanden na uploaden foto worden besteed
•	De korting van € 25,- loopt via cash-back en wordt afgehandeld via hoofdkantoor (Eelco verantwoordelijk voor akkoord uitbetaling)
•	Cash back via pagina op onze site waar klant code/naam/ordernummer en bankrekening moet achterlaten (beetje zoals ook tell a friend). Opmaak deze pagina samen met Marcel. Mails van de klant moeten binnenkomen in aparte map van info@dekeueknvooriedereen.nl zodat het in brokken kan worden opgepakt.
•	€ 25,- wordt in rekening gebracht bij de winkel waar de aanschaf heeft plaatsgevonden. (Eelco maakt voor Frank aan het einde van de actieperiode een overzicht doorbelasting)
•	Klant kan 1 code per aankoop verzilveren en een code maar 1 keer gebruiken
•	Besteding van de korting kan bij aankopen vanaf € 75,-
•	Besteding kan ook met terugwerkende kracht (op een apparaat dat reeds gekocht is). Klant moet zich binnen 5 dagen registreren
•	Aan het einde van een vastgestelde periode (bij de eerste actie per 1 juni of 1 juli 2013 afhankelijk van start campagne) is degene met de meest stemmen op de site winnaar. 
•	Winnaar krijgt bon twv € 750,- te besteden in de webshop of in een winkel
•	Bon is 2 maanden geldig.
•	Kosten voor de bon worden via centraal afgewikkeld
•	Hoofdprijs kan ook met terugwerkende kracht worden besteed als hij maar binnen 2 maanden wordt verzilverd.
•	Winnaar zal vanuit centraal benaderd worden en een eerste intake zal plaatsvinden.(verantwoordelijkheid Eelco)
•	Afhandeling natuurlijk via lokale winkel.
•	Winnaar verplicht zicht via de voorwaarden (dit moet dus ook in de mail staan die de klant krijgt bij het uploaden van een foto) tot het meewerken aan een simpele fotoreportage van het innen van de bon en het eventueel uitvoeren van de renovatie. Deze foto’s mogen wij ook voor reclamedoeleinden gebruiken 

						</div>
						<input type="checkbox" name="terms" <?php if (isset ( $this->_tpl_vars['terms'] )): ?>checked="checked"<?php endif; ?>/> Ik ga akkoord met de voorwaarden<br/>
						<input type="checkbox" name="newsletter" <?php if (isset ( $this->_tpl_vars['newsletter'] )): ?>checked="checked"<?php endif; ?>/> Ik wil de nieuwsbrief ontvangen
					</div>
					<div class="clear">
						<button type="submit">Verzenden</button>
					</div>
				</form>
			</div>
		</div>
	</section>