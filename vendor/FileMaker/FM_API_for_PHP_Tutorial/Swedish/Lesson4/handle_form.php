<?php
    /**
    * FileMaker PHP-exempel
    *
    *
    * Copyright 2006, FileMaker, Inc. Med ensamrätt.
    * OBS! Denna källkod får endast användas i enlighet med villkoren i FileMakers 
    * programvarulicens som följer med koden. Om du använder denna källkod
    * innebär det att du accepterar dessa licensvillkor. Utom för det
    * som uttryckligen medges i programvarulicensen görs inga övriga åtaganden från
    * FileMaker gällande copyright, patent eller annan intellektuell egendom, varken 
    * uttryckligen eller underförstått.
    *
    */
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
    <title>Frågor</title>
</head>
<body>

    <?php include ("dbaccess.php"); ?>

    <h1>FileMakers frågeformulärssystem</h1>
    <hr />
    <?php
        //'respondent_exists' kommer att ställas in om användaren kommer från sidan Respondent.php
    
        if (isset($_POST['respondent_exists']))  {
            
            //Ta tag i indata från användaren från data i $_POST     
            $respondent_data = array(
                                        'Prefix'            => $_POST['prefix'],
                                        'First Name'        => $_POST['first_name'],
                                        'Last Name'         => $_POST['last_name'],
                                        'questionnaire_id'  => $_POST['active_questionnaire_id'],
                                        'Email Address'     => $_POST['email']
                                    );
    
            //Validera indata från användaren.
            if (    empty($respondent_data['Prefix']) 
                ||  empty($respondent_data['First Name'])
                ||  empty($respondent_data['Last Name'])
                ||  empty($respondent_data['Email Address'])) {
                
                //Om data saknas uppmana dem med ett meddelande.
                echo '<h3>Viss information saknas. Gå tillbaka och fyll i alla fält.</h3>';
                exit;
    
            } else {
                
                //Om indata från användare inte är giltiga lägger du till förnamn, efternamn och e-postadress i layouten Respondent.
                $newRequest =& $fm->newAddCommand('Respondent', $respondent_data);
                $result = $newRequest->execute();
                
                //kontrollera om fel finns
                if (FileMaker::isError($result)) {
                    echo "<p>Fel: " . $result->getMessage() . "<p>";
                    exit;
                }
                
                $records = $result->getRecords();
                $record = $records[0];
                $respondent_recid = $record->getField('Respondent ID');
            }
    
            
            /*
             * Nu behöver vi hämta den första frågan i frågeformuläret och visa den för användaren.
             */
    
            //Hämta aktivt frågeformulär och dess post-id.
            $active_questionnaire_id = $_POST['active_questionnaire_id'];
            $active_questionnaire = $fm->getRecordById('questionnaire',$active_questionnaire_id);    

            //Utför en sökning i layouten 'Questions' efter frågor som hör till det här frågeformuläret    
            $findCommand =& $fm->newFindCommand('Questions');    
            $findCommand->addFindCriterion('Questionnaire ID', $active_questionnaire_id);    
            $result = $findCommand->execute();
            
            //kontrollera om fel finns
            if (FileMaker::isError($result)) {
                echo "<p>Fel: " . $result->getMessage() . "<p>";
                exit;
            }
    
    
    
            //Hämta frågan och frågetyp för den första frågeposten.    
            $records = $result->getRecords();
            $question = $records[0];    
            $real_question = $question->getField('question');    
            $question_type = $question->getField('Question Type');    
            $cur_question = $records[0]->getRecordID();
    
            //Skriv ut frågan.    
            echo "<p>".$real_question."</p>";    
            echo '<form action="thankyou.php" method= "POST">';            
    
            /*
             * Mata ut korrekt HTML-formelement baserat på värdet i $question_type
             */
    
            if ($question_type == "text" ) {
    
                //visa textindata.    
                echo '<input type="text" name="text_answer" size="60" value=""/>';
                
            } else if ($question_type =="radio" || $question_type =="ranking") {
                
                /*
                 * Om question_type begär alternativknappar behöver vi hämta en
                 * lista över acceptabla svar på denna fråga.
                 * Obs! Frågor av typen 'radio' och 'ranking' implementeras på samma sätt
                 * och båda använder alternativknappar för indata från användare.
                 */
    
                //Hämta portalen 'question_answers'
    
                $relatedSet = $question->getRelatedSet('question_answers');
    
                //kontrollera om fel finns
                if (FileMaker::isError($relatedSet)) {
                    echo "<p>Fel: " . $relatedSet->getMessage(). "</p>";
                    exit;
                }
                
                //visa varje möjligt svar som en HTML-alternativknapp
                foreach ($relatedSet as $relatedRow) {
                    $possible_answer = $relatedRow->getField('question_answers::answer');
                    echo '<input type= "radio" name= "radio_answer" value= "'. $possible_answer .'">' . $possible_answer . '<br/>'; 
                }
    
            } else if ($question_type == "pulldown") {
    
                /*
                 * Om question_type begär rullgardinsmenyer behöver vi hämta en
                 * lista över acceptabla svar på denna fråga.
                 */
                
                //Hämta portalen 'question_answers'
                $relatedSet = $question->getRelatedSet('question_answers');
                
                //kontrollera om fel finns
                if (FileMaker::isError($relatedSet)) {
                    echo "<p>Fel: " . $relatedSet->getMessage(). "</p>";
                    exit;
                }
                
                //skriv ut start-tagg för en HTML-rullgardinsmeny
                echo '<select name="pulldown">';
                
                //visa alla möjliga svar som ett alternativ i HTML-rullgardinsmeny
                foreach ($relatedSet as $relatedRow)  {
                    $possible_answer = $relatedRow->getField('question_answers::answer');
                    echo '<option value="' . $possible_answer .'">' . $possible_answer . '</option>'; 
                 }
                
                //skriv ut slut-tagg för en HTML-rullgardinsmeny
    
                echo '</select>';
    
            } else if($question_type == "checkbox") {
               
                /*
                 * Om question_type begär kryssrutor behöver vi hämta en
                 * lista över acceptabla svar på denna fråga.
                 */
                
                //Hämta portalen 'question_answers'
                $relatedSet = $question->getRelatedSet('question_answers');
                
                //kontrollera om fel finns
                
                if (FileMaker::isError($relatedSet)) {
                    echo "<p>Fel: " . $relatedSet->getMessage(). "</p>";
                    exit;
                }
                
                //visa varje möjligt svar som HTML-kryssruta
                foreach ($relatedSet as $relatedRow) {
                    $possible_answer = $relatedRow->getField('question_answers::answer');
                    echo '<input type= "checkbox" name="cbanswer[]" value= "' . $possible_answer . '"/ >' . $possible_answer . '<br/>';
                }
    
            } else {
                //Om $question_type inte har definierats eller inte känns igen, är standard HTML-textindata
                echo '<input type="text" name="text_answer" size="60" value=""/>';
            }
            
            echo '<hr />';
            
            /*
             * Här ställer vi in värden för dolt formulär som skickas till nästa sida via $_POST.
             * 
             *         'store_information' -- alltid inställt, säger till nästa sida att spara svaret på DEN HÄR frågan
             *         'question_type' -- formatet på svaret (text, radio, rangordning, rullgardin eller kryssruta)
             *         'respondent_id' -- post-ID för posten för svarande
             *         'cur_question' -- post-ID för aktuell frågepost
             */
           
           echo '<input type="hidden" name="store_information" value="store_information"/>';
            echo '<input type="hidden" name="question_type" value="' . $question_type . '">';              
            echo '<input type="hidden" name="respondent_id" value="' . $respondent_recid . '"/>';
            echo '<input type="hidden" name="cur_question" value="' . $cur_question . '"/>';
            echo '<input type="Submit" name="submit" value="Skicka" />';
            
            //skriva ut slut-tagg för HTML-formulär
            echo '</form>';
        }
    ?>

</body>

</html>

