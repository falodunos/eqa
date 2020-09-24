<?php
namespace Admin\Service\Contract\Question;

use Admin\Entity\Contract\Question\ImageInterface as QuestionImageInterface;

interface ImageServiceInterface
{

    public function getAllQuestionImages();

    /**
     *
     * @param integer $id            
     */
    public function getQuestionImage($id);

    /**
     *
     * @param $data, $files    
     */
    public function upload($form, $data, $files);

    /**
     *
     * @param ImageInterface $questionImage          
     */
    public function deleteQuestionImage(QuestionImageInterface $questionImage);
}