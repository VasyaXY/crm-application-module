<?php

namespace Crm\ApplicationModule\Config\Repository;

use Crm\ApplicationModule\Repository;
use Crm\ApplicationModule\Repository\AuditLogRepository;
use DateTime;
use Nette\Database\Context;
use Nette\Database\Table\IRow;

class ConfigsRepository extends Repository
{
    protected $tableName = 'configs';

    public function __construct(
        Context $database,
        AuditLogRepository $auditLogRepository
    ) {
        parent::__construct($database);
        $this->auditLogRepository = $auditLogRepository;
    }

    final public function loadAllAutoload()
    {
        return $this->getTable()->where('autoload', true)->order('sorting');
    }

    final public function loadByName($name)
    {
        return $this->getTable()->where('name', $name)->fetch();
    }

    final public function loadByCategory(IRow $configCategory)
    {
        return $this->loadByCategoryId($configCategory->id);
    }

    final public function loadByCategoryId($configCategoryId)
    {
        return $this->getTable()->where('config_category_id', $configCategoryId)->order('sorting');
    }

    final public function update(IRow &$row, $data)
    {
        $data['updated_at'] = new DateTime();
        if (!isset($data['has_default_value'])) {
            $data['has_default_value'] = false;
        }
        return parent::update($row, $data);
    }
}
