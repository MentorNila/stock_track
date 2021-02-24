<?php namespace App\Models\Base;

trait L10nBase {

	protected function buildL10nName($table, $l10nTable, $column, $alias = null) {
		return \DB::raw('IFNULL(' . $l10nTable . '.' . $column . ', '. $table . '.' . $column . ')' . ($alias ? ' as ' . $alias : ''));
	}

	protected function getL10nModel() {
		return empty($this->l10n_model) ? get_class($this) . 'L10n' : $this->l10n_model;
	}

	protected function getL10nForeignKey() {
		return empty($this->l10n_foreign_key) ? 'foreign_id' : $this->l10n_foreign_key;
	}

	public function scopeSelectL10n($builder, $columns, $language = null) {
		if (is_null($language)) {
			$language = \Lang::getLocale();
		}

		if (empty($language)) {
			return $this->select($columns);
		}
		else {
			$model = $this->getL10nModel();
			$table = $this->getTable();
			$l10nTable = (new $model)->getTable();
			$foreignKey = $this->getL10nForeignKey();

			$fields = [];
			foreach ((array)$columns as $key => $column) {
				$fields[] = $this->buildL10nName($table, $l10nTable, is_int($key) ? $column : $key, $column);
			}

			return $builder->leftJoin($l10nTable, function($join) use ($table, $l10nTable, $foreignKey, $language) {
				$join->on($table . '.id', '=', $l10nTable . '.' . $foreignKey);
				$join->where($l10nTable . '.language_code', '=', $language);
			})->addSelect($fields);
		}
	}

	public function l10nColumn($column) {
		$model = $this->getL10nModel();
		return $this->buildL10nName($this->getTable(), (new $model)->getTable(), $column);
	}

}
