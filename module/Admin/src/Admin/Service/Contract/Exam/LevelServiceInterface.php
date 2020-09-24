<?php
namespace Admin\Service\Contract\Exam;

use Admin\Entity\Contract\Exam\LevelInterface;

interface LevelServiceInterface
{

    public function findAllLevels();

    /**
     *
     * @param integer $id            
     */
    public function findLevel($id);

    /**
     *
     * @param ExamInterface $level            
     */
    public function saveLevel($level_data);

    /**
     *
     * @param ExamInterface $level            
     */
    public function deleteLevel(LevelInterface $exam);
    
    /**
     *
     * @param ExamInterface $level
     */
    public function findLevelBy(array $criteria);
}