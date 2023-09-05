<?php
namespace Edgewise;

class Project
{
  private $client;

  /**
   */
  function __construct($client)
  {
    $this->client = $client;
  }

  /**
   * Response array keys:
   *   id
   *   title
   *   slug
   *   status
   *   address
   *     thoroughfare
   *     locality
   *     administrativeArea
   *     postalCode
   *   salesOffice
   *     phone
   *     email
   *   abstract
   *     units
   *       moveInReady
   *       available
   *       sold
   *       total
   *   socialLinks
   *     facebook
   *     twitter
   *     instagram
   *   overview
   *   overviewHeadline
   *   insertedAt
   *   updatedAt 
   * 
   * @return array
   */
  public function get($project_id)
  {
    $query = $this->client->encodeQuery([
      "query" => $this->getQuery(),
      "variables" => ["id" => $project_id]
    ]);

    $response = $this->client->request($query);
    return $this->client->handleResponse($response)["project"];
  }

  /**
   * Response array keys:
   *  id
   *  title
   *  slug
   *    walkScore
   *      link
   *      walkScore
   *      walkScoreDescription
   *      bikeScore
   *      bikeScoreDescription
   *      transitScore
   *      transitScoreDescription
   * 
   * @return array
   */
  public function getWalkScore($project_id)
  {
    $query = $this->client->encodeQuery([
      "query" => $this->getWalkScoreQuery(),
      "variables" => ["id" => $project_id]
    ]);

    $response = $this->client->request($query);
    return $this->client->handleResponse($response)["project"]["walkScore"];
  }

  /**
   */
  public function allImages($project_id)
  {
    $query = $this->client->encodeQuery([
      "query" => $this->allImagesQuery(),
      "variables" => ["id" => $project_id]
    ]);

    $response = $this->client->request($query);
    return $this->client->handleResponse($response)["project"]["images"];
  }

  /**
   */
  public function allPublicDocuments($project_id)
  {
    $query = $this->client->encodeQuery([
      "query" => $this->allPublicDocumentsQuery(),
      "variables" => ["id" => $project_id]
    ]);

    $response = $this->client->request($query);
    $documents = $this->client->handleResponse($response)["project"]["documents"];
    return array_filter($documents, function($document) {
      return $document["public"];
    });
  }

  /**
   */
  public function allUnits($project_id)
  {
    $query = $this->client->encodeQuery([
      "query" => $this->allUnitsQuery(),
      "variables" => ["id" => $project_id]
    ]);

    $response = $this->client->request($query);
    return $this->client->handleResponse($response)["project"]["units"];
  }

  /**
   * DEPRECATED
   */
  public function allSecondarySources($project_id)
  {
    return $this->allSources($project_id);
  }

  /**
   */
  public function allSources($project_id)
  {
    $query = $this->client->encodeQuery([
      "query" => $this->allLeadSourcesQuery(),
      "variables" => ["id" => $project_id]
    ]);

    $response = $this->client->request($query);
    return $this->client->handleResponse($response)["project"]["leadSources"];
  }

  /**
   */
  public function contact($input)
  {
    $query = $this->client->encodeQuery([
      "query" => $this->contactQuery(),
      "variables" => ["input" => $input]
    ]);

    $response = $this->client->request($query);
    return $this->client->handleResponse($response)["contactProject"];
  }

  /**
   */
  private function getQuery()
  {
    return 'query PHPSdkGetProject($id: ID!) {
      project(id: $id) {
        id
        title
        slug
        status
        address {
          thoroughfare
          locality
          administrativeArea
          postalCode
        }
        salesOffice {
          phone
          email
        }
        abstract {
          units {
            moveInReady
            available
            sold
            total
          }
        }
        socialLinks {
          facebook
          twitter
          instagram
        }
        overview
        overviewHeadline
        insertedAt
        updatedAt
      }
    }';
  }

  /**
   */
  private function getWalkScoreQuery()
  {
    return 'query PHPSdkGetProjectWalkScore($id: ID!) {
      project(id: $id) {
        id
        title
        slug
        walkScore {
          link
          walkScore
          walkScoreDescription
          bikeScore
          bikeScoreDescription
          transitScore
          transitScoreDescription
        }
      }
    }';
  }

  /**
   */
  private function allLeadSourcesQuery()
  {
    return 'query PHPSdkAllProjectLeadSources($id: ID!) {
      project(id: $id) {
        id
        title
        slug
        leadSources {
          id
          name
        }
      }
    }';
  }

  /**
   */
  private function allImagesQuery()
  {
    return 'query PHPSdkAllProjectImages($id: ID!) {
      project(id: $id) {
        id
        title
        slug
        images {
          id
          title
          sequence
          url
        }
      }
    }';
  }

  /**
   */
  private function allPublicDocumentsQuery()
  {
    return 'query PHPSdkAllProjectPublicDocument($id: ID!) {
      project(id: $id) {
        id
        documents {
          id
          description
          filename
          filemime
          filesize
          public
          url
        }
      }
    }';
  }

  /**
   */
  private function allUnitsQuery()
  {
    return 'query PHPSdkAllProjectUnits($id: ID!) {
      project(id: $id) {
        id
        title
        slug
        units {
          id
          title
          status
          price
          floorPlan {
            id
            title
          }
        }
      }
    }';
  }

  private function contactQuery()
  {
    return 'mutation PHPSdkContactProject($input: ContactProjectInput!) {
      contactProject(input: $input) {
        id
      }
    }';
  }
}
