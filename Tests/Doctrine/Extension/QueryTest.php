<?php
namespace Exeu\MiscBundle\Tests\Doctrine\Extension;

class QueryTest extends \PHPUnit_Framework_TestCase
{
	private $entityManager;
	
	public function setUp()
	{
		$config = new \Doctrine\ORM\Configuration();
		$config->setMetadataCacheImpl(new \Doctrine\Common\Cache\ArrayCache());
        $config->setQueryCacheImpl(new \Doctrine\Common\Cache\ArrayCache());
        $config->setProxyDir('/tmp/');
        $config->setProxyNamespace('Proxie');
        $config->setAutoGenerateProxyClasses(true);

        $driver = $config->newDefaultAnnotationDriver(__DIR__.'/Entities', false);
        $config->setMetadataDriverImpl($driver);
		
        
        $config->addCustomNumericFunction('RAND', "Exeu\MiscBundle\Doctrine\Extension\Rand");
        $conn = array(
            'driver' => 'pdo_sqlite',
            'memory' => true,
        );
        
        $this->entityManager = \Doctrine\ORM\EntityManager::create($conn, $config);
	}
	
	public function testMe()
	{
		$query = $this->entityManager->createQuery("SELECT RAND() as rand FROM Exeu\MiscBundle\Tests\Entities\TestEntity p");
		$expectedSql = 'SELECT RAND() AS sclr0 FROM TestEntity t0_';
		
		$this->assertEquals($query->getSql(), $expectedSql);
	}
}