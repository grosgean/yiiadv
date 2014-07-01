<?php

namespace backend\functions;

class Functions
{

	public static function myFunction ($data) {
/* 		echo "<PRE>";
		var_dump($data);
		echo "</PRE>"; */
	}
	
	public static function _recursiveGetCategoryCompactCList( $path, $level )
	{
		if(!$path[$level-1]["categoryID"]){
			return array();
		}

		$query = (new \yii\db\Query())
			->select('categoryID, slug, parent, name')
			->from('categories')
			->where('parent=:parent', [':parent' => $path[$level-1]["categoryID"]])
			->orderBy(['sort_order' => SORT_ASC ,'name' => SORT_ASC]);

		$res = array();
		$selectedCategoryID = null;
		foreach ($query->each() as $row) {

			$row["level"] = $level;
			$res[] = $row;
			if ( $level <= count($path)-1 )	{
				if ( (int)$row["categoryID"] == (int)$path[$level]["categoryID"] ){
					$selectedCategoryID = $row["categoryID"];
					$array = self::_recursiveGetCategoryCompactCList( $path, $level+1 );
					foreach( $array as $val ){
						$res[] = $val;
					}
				}
			}
		}

		return $res;
	}
	
	public static function catGetCategoryCompactCList( $selectedCategoryID )
	{
		static $cached_result = array();
		$selectedCategoryID = intval($selectedCategoryID);
		if(false&&isset($cached_result[$selectedCategoryID])){
			$res = $cached_result[$selectedCategoryID];
		}else{
			$path = self::catCalculatePathToCategory( $selectedCategoryID );
			$res = array();
			$res[] = array(
				"categoryID" => 1,
				"parent"	 => null,
				"name"		 => 'ROOT',
				"level"		 => 0,
			);
			
			$query = (new \yii\db\Query())
				->select('categoryID, slug, parent, name')
				->from('categories')
				->where('parent=:parent', [':parent' => 1])
				->orderBy(['sort_order' => SORT_ASC ,'name' => SORT_ASC]);

			foreach ($query->each() as $row) {
				$row["level"] = 1;
				$res[] = $row;
				if ( count($path) > 1 ){
					if ( $row["categoryID"] == $path[1]["categoryID"] )	{
						$array = self::_recursiveGetCategoryCompactCList( $path, 2 );
						foreach( $array as $val ){
							$res[] = $val;
						}
					}
				}
			}
			$cached_result[$selectedCategoryID] = $res;
		}
		return $res;
	}
	
	public static function catCalculatePathToCategory( $categoryID )
	{
		$categoryID = (int)$categoryID;
		if (!$categoryID) return NULL;
		static $cached_path = array();
		if(false&&isset($cached_path[$categoryID])){
			$path = $cached_path[$categoryID];
		}else{
			$path = array();

			$count = (new \yii\db\Query())
				->from('categories')
				->where('categoryID=:categoryID', [':categoryID' => $categoryID])
				->count();

			if ( $count == 0 )
			return $path;

			$curr = intval($categoryID);
			do
			{

				$query = (new \yii\db\Query())
				->select('categoryID, slug, parent, name')
				->from('categories')
				->where('categoryID=:categoryID', [':categoryID' => $curr])
				->one();

				$path[] = $query;

				if ( $curr <= 1 )
				break;

				$curr = intval($query["parent"]);
			}
			while ( 1 );
			//now reverse $path
			$path = array_reverse($path);
			$cached_path[$categoryID] = $path;
		}
		return $path;
	}

}
