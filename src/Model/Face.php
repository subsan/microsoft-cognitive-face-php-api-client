<?php

namespace Subsan\MicrosoftCognitiveFace\Model;

use Subsan\MicrosoftCognitiveFace\Model;

class Face extends Model
{
    /**
     * Detect human faces in an image, return face rectangles, and optionally with faceIds, landmarks, and attributes.
     *
     * Optional parameters including faceId, landmarks, and attributes. Attributes include age, gender, headPose, smile, facialHair, glasses, emotion, hair, makeup, occlusion, accessories, blur, exposure and noise.
     * faceId will be used in Face - Identify, Face - Verify, and Face - Find Similar. It will expire 24 hours after the detection call.
     * Higher face image quality means better detection and recognition precision. Please consider high-quality faces: frontal, clear, and face size is 200x200 pixels (100 pixels between eyes) or bigger.
     * JPEG, PNG, GIF (the first frame), and BMP format are supported. The allowed image file size is from 1KB to 6MB.
     * Faces are detectable when its size is 36x36 to 4096x4096 pixels. If need to detect very small but clear faces, please try to enlarge the input image.
     * Up to 64 faces can be returned for an image. Faces are ranked by face rectangle size from large to small.
     * Face detector prefer frontal and near-frontal faces. There are cases that faces may not be detected, e.g. exceptionally large face angles (head-pose) or being occluded, or wrong image orientation.
     * Attributes (age, gender, headPose, smile, facialHair, glasses, emotion, hair, makeup, occlusion, accessories, blur, exposure and noise) may not be perfectly accurate. HeadPose's pitch value is a reserved field and will always return 0.
     *
     * @param string $url
     * @param bool   $returnFaceId
     * @param bool   $returnFaceLandmarks
     * @param string $returnFaceAttributes
     *
     * @return mixed
     * @throws \Subsan\MicrosoftCognitiveFace\Exception\ClientException
     */
    public function detectFacesFromImg(string $url = '', bool $returnFaceId = true, bool $returnFaceLandmarks = false, string $returnFaceAttributes = 'age,gender,headPose,smile,facialHair,glasses,emotion,hair,makeup,occlusion,accessories,blur,exposure,noise')
    {
        $parameters = [
            'url' => $url
        ];

        $form_params = [
            'returnFaceId'         => (int)$returnFaceId,
            'returnFaceLandmarks'  => (int)$returnFaceLandmarks,
            'returnFaceAttributes' => $returnFaceAttributes
        ];


        $response = $this->client->request('POST', 'detect', $parameters, $form_params);

        return json_decode((string)$response->getBody());
    }

    /**
     * 1-to-many identification to find the closest matches of the specific query person face from a person group or large person group.
     *
     * For each face in the faceIds array, Face Identify will compute similarities between the query face and all the faces in the person group (given by personGroupId) or large person group (given by largePersonGroupId), and return candidate person(s) for that face ranked by similarity confidence. The person group/large person group should be trained to make it ready for identification. See more in PersonGroup - Train and LargePersonGroup - Train
     *
     * @param array       $faceIds
     * @param string|null $personGroupId
     * @param string|null $largePersonGroupId
     * @param float|null  $confidenceThreshold
     * @param int|null    $maxNumOfCandidatesReturned
     *
     * @return mixed
     * @throws \Subsan\MicrosoftCognitiveFace\Exception\ClientException
     */
    public function identify(array $faceIds, string $personGroupId = null, string $largePersonGroupId = null, float $confidenceThreshold = null, int $maxNumOfCandidatesReturned = null)
    {
        $bodyParameters = [
            'faceIds'                    => $faceIds,
            'personGroupId'              => $personGroupId,
            'largePersonGroupId'         => $largePersonGroupId,
            'maxNumOfCandidatesReturned' => $maxNumOfCandidatesReturned,
            'confidenceThreshold'        => $confidenceThreshold
        ];

        $response = $this->client->request('POST', 'identify', $bodyParameters);

        return json_decode((string)$response->getBody());
    }

    /**
     * Divide candidate faces into groups based on face similarity
     *
     * The output is one or more disjointed face groups and a messyGroup. A face group contains faces that have similar looking, often of the same person. Face groups are ranked by group size, i.e. number of faces. Notice that faces belonging to a same person might be split into several groups in the result.
     * MessyGroup is a special face group containing faces that cannot find any similar counterpart face from original faces. The messyGroup will not appear in the result if all faces found their counterparts.
     * Group API needs at least 2 candidate faces and 1000 at most. We suggest to try Face - Verify when you only have 2 candidate faces.
     *
     * @param array $faceIds
     *
     * @return mixed
     * @throws \Subsan\MicrosoftCognitiveFace\Exception\ClientException
     */
    public function group(array $faceIds)
    {
        $bodyParameters = [
            'faceIds' => $faceIds
        ];

        $response = $this->client->request('POST', 'group', $bodyParameters);

        return json_decode((string)$response->getBody());
    }

    /**
     * Given query face's faceId, to search the similar-looking faces from a faceId array, a face list or a large face list. faceId array contains the faces created by Face - Detect, which will expire 24 hours after creation. A "faceListId" is created by FaceList - Create containing persistedFaceIds that will not expire. And a "largeFaceListId" is created by LargeFaceList - Create containing persistedFaceIds that will also not expire. Depending on the input the returned similar faces list contains faceIds or persistedFaceIds ranked by similarity.
     * Find similar has two working modes, "matchPerson" and "matchFace". "matchPerson" is the default mode that it tries to find faces of the same person as possible by using internal same-person thresholds. It is useful to find a known person's other photos. Note that an empty list will be returned if no faces pass the internal thresholds. "matchFace" mode ignores same-person thresholds and returns ranked similar faces anyway, even the similarity is low. It can be used in the cases like searching celebrity-looking faces.
     *
     * @param string      $faceId
     * @param string|null $faceListId
     * @param string|null $largeFaceListId
     * @param array|null  $faceIds
     * @param int|null    $maxNumOfCandidatesReturned
     * @param string|null $mode
     *
     * @return mixed
     * @throws \Subsan\MicrosoftCognitiveFace\Exception\ClientException
     */
    public function findSimilar(string $faceId, string $faceListId = null, string $largeFaceListId = null, array $faceIds = null, int $maxNumOfCandidatesReturned = null, string $mode = null)
    {
        $bodyParameters = [
            'faceId'                     => $faceId,
            'faceListId'                 => $faceListId,
            'largeFaceListId'            => $largeFaceListId,
            'faceIds'                    => $faceIds,
            'maxNumOfCandidatesReturned' => $maxNumOfCandidatesReturned,
            'mode'                       => $mode
        ];

        $response = $this->client->request('POST', 'findsimilars', $bodyParameters);

        return json_decode((string)$response->getBody());
    }

    /**
     * Verify whether two faces belong to a same person
     *
     * Remarks:
     * Higher face image quality means better identification precision. Please consider high-quality faces: frontal, clear, and face size is 200x200 pixels (100 pixels between eyes) or bigger.
     * For the scenarios that are sensitive to accuracy please make your own judgment.
     *
     * @param string $faceId1
     * @param string $faceId2
     *
     * @return mixed
     * @throws \Subsan\MicrosoftCognitiveFace\Exception\ClientException
     */
    public function verifyTwoFaces(string $faceId1, string $faceId2)
    {
        $bodyParameters = [
            'faceId1' => $faceId1,
            'faceId2' => $faceId2
        ];

        $response = $this->client->request('POST', 'verify', $bodyParameters);

        return json_decode((string)$response->getBody());
    }

    /**
     * Verify whether one face belongs to a person.
     *
     * @param string $faceId
     * @param string $personGroupId
     * @param string $largePersonGroupId
     * @param string $personId
     *
     * @return mixed
     * @throws \Subsan\MicrosoftCognitiveFace\Exception\ClientException
     */
    public function verifyFaceToPerson(string $faceId, string $personGroupId, string $largePersonGroupId, string $personId)
    {
        $bodyParameters = [
            'faceId'             => $faceId,
            'personGroupId'      => $personGroupId,
            'largePersonGroupId' => $largePersonGroupId,
            'personId'           => $personId
        ];

        $response = $this->client->request('POST', 'verify', $bodyParameters);

        return json_decode((string)$response->getBody());
    }
}
