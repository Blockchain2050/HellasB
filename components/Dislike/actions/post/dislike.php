<?php
/**
 * Open Source Social Network
 *
 * @packageOpen Source Social Network
 * @author    Open Social Website Core Team <info@informatikon.com>
 * @copyright 2014 iNFORMATIKON TECHNOLOGIES
 * @license   General Public Licence http://www.opensource-socialnetwork.org/licence
 * @link      http://www.opensource-socialnetwork.org/licence
 */
$dislike = new Dislike;
$anotation = input('post');
$entity = input('entity');
if (!empty($anotation)) {
    $subject = $anotation;
    $type = 'post';
}
if (!empty($entity)) {
    $subject = $entity;
    $type = 'entity';

}
if ($dislike->SetDislike($subject, ossn_loggedin_user()->guid, $type)) {
    if (!ossn_is_xhr()) {
        redirect(REF);
    } else {
        header('Content-Type: application/json');
        echo json_encode(array(
                'done' => 1,
            ));
    }
} else {
    if (!ossn_is_xhr()) {
        redirect(REF);
    } else {
        header('Content-Type: application/json');
        echo json_encode(array(
                'done' => 0,
            ));
    }
}
exit;
