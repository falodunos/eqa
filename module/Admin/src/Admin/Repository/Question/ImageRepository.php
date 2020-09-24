<?php
namespace Admin\Repository\Question;

use Base\Repository\BaseDbRepository;
use Admin\Repository\Contract\Question\ImageRepositoryInterface;

class ImageRepository extends BaseDbRepository implements ImageRepositoryInterface
{

    /*
     * (non-PHPdoc)
     * @see \Admin\Repository\Contract\Question\ImageRepositoryInterface::fetchByIsActive()
     */
    public function fetchByIsActive($imageIsActive)
    {}

    public function update($entity)
    {}

    public function getQuestionImagesDbInfo($imageInfo, $fileName = null)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('image')
            ->from($this->_entityName, 'image')
            ->where('image.institution = :instId')
            ->andWhere('image.department = :deptId')
            ->andWhere('image.exam = :examId')
            ->andWhere('image.subject = :subjectId')
            ->andWhere('image.paper = :paperId')
            ->andWhere('image.section = :sectionId')
            ->andWhere('image.question = :questionId')
            ->setParameters(array(
            'instId' => $imageInfo['instId'],
            'deptId' => $imageInfo['deptId'],
            'examId' => $imageInfo['examId'],
            'subjectId' => $imageInfo['subjectId'],
            'paperId' => $imageInfo['paperId'],
            'sectionId' => $imageInfo['sectionId'],
            'questionId' => $imageInfo['questionId']
        ));
        $query = is_null($fileName) ? $qb->getQuery() : $qb->andWhere('image.documentName = :documentName')
            ->setParameter('documentName',$fileName)
            ->getQuery();
        return $query->getResult();
    }

    public function deleteImageTrailFromDb($fileName, $imageInfo)
    {
        $selection = $this->getQuestionImagesDbInfo($imageInfo, $fileName);
        return count($selection) > 0 ? $this->delete($selection[0]) : false; //return true if deleted else return false
    }
}