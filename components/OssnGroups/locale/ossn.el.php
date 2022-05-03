<?php
/**
 * Open Source Social Network
 *
 * @package   Open Source Social Network
 * @author    Open Social Website Core Team <info@softlab24.com>
 * @copyright (C) SOFTLAB24 LIMITED
 * @license   Open Source Social Network License (OSSN LICENSE)  http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */
$en = array(
    'groups' => 'Ομάδες',
    'add:group' => 'Δημιουργία Ομάδας',
    'requests' => 'Αιτήματα',

    'members' => 'Μέλη',
    'member:add:error' => 'Κάτι πήγε λάθος. Παρακαλώ ξαναπροσπαθήστε.',
    'member:added' => 'Το αίτημα έγινε δεχτό!',

    'member:request:deleted' => 'Το αίτημα απορρίθφηκε!',
    'member:request:delete:fail' => 'Δεν μπορείτε να απορρίψετε το αίτημα, παρακαλώ προσπαθήστε αργότερα.',
    'membership:cancel:succes' => 'Το αίτημα ακυρώθηκε!',
    'membership:cancel:fail' => 'Δεν μπορείτε να ακυρώσετε το αίτημα, παρακαλώ προσπαθήστε αργότερα.',

    'group:added' => 'Η Ομάδα δημιουργήθηκε με επιτυχία!',
    'group:add:fail' => 'Δεν μπορείτε να δημιουργήσετε την ομάδα, παρακαλώ δοκιμάστε αργότερα.',

    'memebership:sent' => 'Το αίτημα στάλθηκε με επιτυχία!',
    'memebership:sent:fail' => 'Δεν μπορείτε να στείλετε το αίτημα, παρακαλώ προσπαθήστε αργότερα..',

    'group:updated' => 'Η Ομάδα ενημερώθηκε!',
    'group:update:fail' => 'Δεν μπορείτε να ενημερώσετε την ομάδα, παρακαλώ προσπαθήστε αργότερα.',

    'group:name' => 'Όνομα Ομάδας',
    'group:desc' => 'Περιγραφή Ομάδας',
    'privacy:group:public' => 'Όλοι μπορούν να δουν αυτή την ομάδα και τις δημοσιεύσεις της. Μόνο τα μέλη μπορούν να δημοσιεύσουν.',
    'privacy:group:close' => 'Όλοι μπορούν να δουν την ομάδα. Μόνο τα μέλη μπορούν να δουν και να δημιουργήσουν δημοσιεύσεις.',

    'group:memb:remove' => 'Αφαίρεση',
    'group:memb:make:owner' => 'Αλλαγή ιδιοκτήτη Ομάδας',
    'group:memb:make:owner:confirm' => 'Προσοχή! Αυτή η πράξη θα κάνει τον >> %s << ιδιοκτήτη της ομάδας και εσείς θα χάσετε όλα τα δικαιώματα διαχειριστή. Είστε σίγουροι ότι θέλετε να προχωρήσετε;',
    'group:memb:make:owner:admin:confirm' => 'Προσοχή! Αυτή η πράξη θα κάνει τον >> %s << ιδιοκτήτη της ομάδας και εσείς θα χάσετε όλα τα δικαιώματα διαχειριστή. Είστε σίγουροι ότι θέλετε να προχωρήσετε;',
    'leave:group' => 'Αποχώρηση από την Ομάδα',
    'join:group' => 'Ένταξη στην Ομάδα ',
    'total:members' => 'Συνολικά Μέλη',
    'group:members' => "Μέλη (%s)",
    'view:all' => 'Προβολή Όλων',
    'member:requests' => 'Αιτήματα (%s)',
    'about:group' => 'Περί Ομάδας',
    'cancel:membership' => 'Ακύρωση κατάστασης μέλους',

    'no:requests' => 'Κανένα Αίτημα',
    'approve' => 'Αποδοχή',
    'decline' => 'Απόρριψη',
    'search:groups' => 'Αναζήτηση Ομάδων',

    'close:group:notice' => 'Μπείτε σε αυτή την Ομάδα για να δείτε τις δημοσιεύσεις, τις φωτογραφίες και τα σχόλια.',
    'closed:group' => 'Κλειστή Ομάδα',
    'group:admin' => 'Διαχειριστής',
	
	'title:access:private:group' => 'Δημοσίευση Ομάδας',

	// #186 group join request message var1 = user, var2 = name of group
	'ossn:notifications:group:joinrequest' => 'Ο/Η %s θέλει να ενταχθεί στην ομάδα %s',
	'ossn:group:by' => 'Από:',
	
	'group:deleted' => 'Η ομάδα και τα περιεχόμενα της διαγράφηκαν',
	'group:delete:fail' => 'Η ομάδα δεν μπορεί να διαγραφεί',

	'group:delete:cover' => 'Διαγραφή Εξωφύλλου',
	'group:delete:cover:error' => 'Προέκυψε σφάλμα κατά την διαγραφή του εξωφύλλου',
	'group:delete:cover:success' => 'Το εξώφυλλο διαγράφηκε.',

);
ossn_register_languages('el', $en); 
