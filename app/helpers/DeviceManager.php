<?php
    namespace NomadicBits\DemoBundle\Manager;

    use NomadicBits\CDRatorSoapClient\Action\ManageDevice;

    class DeviceManager {


        public function GetSprintDeviceStatus($meid, $ownerShipCode = null) {
            $manageDevice = new ManageDevice();
            $manageDevice->MEID = $meid;
            if (!is_null($ownerShipCode)) {
                $manageDevice->OwnerShipCode;
            }
            return $response = $manageDevice->executeRequest();
        }

        public function getBYOSDDeviceList($em, $searchTerm) {
            $repository = $em->getRepository('NomadicBitsDemoBundle:ByosdHandset');

            //$handsetList = $repository->findAll();

            /* @var ByosdHandset[] $handsetList */
            $handsetList = $em->createQuery("SELECT d FROM NomadicBitsDemoBundle:ByosdHandset d WHERE CONCAT(d.manufacturer, CONCAT(' ', d.name)) like :searchterm")
                ->setParameter('searchterm', '%'.$searchTerm.'%')
                ->getResult();

            $tmpList = array();

            foreach($handsetList as $handset) {
                $tmp = new \stdClass;
                $tmp->id = $handset->getId();
                $tmp->name = $handset->getName();
                $tmp->manufacturer = $handset->getManufacturer();
                $tmp->label = sprintf('%s %s', $handset->getManufacturer(), $handset->getName());
                $tmpList[] = $tmp;
            }

            return json_encode($tmpList);

        }

        public function tcon(){
            $manageDevice = new ManageDevice();
            return $response = $manageDevice->testaccount();
        }

    }

?>