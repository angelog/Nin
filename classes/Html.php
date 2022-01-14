<?php

namespace Nin;

class Html
{
	public static function encode($str)
	{
		return htmlentities($str, ENT_QUOTES, 'UTF-8');
	}

	private static function maketag($tagname, $void = true, $options = [])
	{
		$ret = '<' . $tagname;
		foreach($options as $k => $v) {
			if($v == '') {
				continue;
			}
			if(is_int($k)) {
				$ret .= ' ' . $v;
			} else {
				$ret .= ' ' . $k . '="' . Html::encode($v) . '"';
			}
		}
		if($void) {
			$ret .= '>';
		} else {
			$ret .= ' />';
		}
		return $ret;
	}

	public static function activeText($model, $key, $options = [])
	{
		return Html::maketag('input', true, array_merge([
			'type' => 'text',
			'name' => get_class($model) . '[' . $key . ']',
			'value' => $model->$key
		], $options));
	}

	public static function activeTextarea($model, $key, $options = [])
	{
		$ret = Html::maketag('textarea', true, array_merge([
			'name' => get_class($model) . '[' . $key . ']'
		], $options));
		$ret .= $model->$key;
		$ret .= '</textarea>';
		return $ret;
	}

	public static function activeRadio($model, $key, $values = [], $options = [])
	{
		$ret = '';
		foreach($values as $k => $v) {
			$checked = '';
			if($model->$key !== false && $model->$key == $k) {
				$checked = 'checked';
			}
			$ret .= '<label>' . Html::maketag('input', true, array_merge([
				'type' => 'radio',
				'name' => get_class($model) . '[' . $key . ']',
				'value' => $k,
				$checked
			], $options)) . ' ' . $v . '</label>' . "\n";
		}
		return $ret;
	}

	public static function activeDate($model, $key, $format, $options = [])
	{
		$date = '';
		if($model->$key) {
			$date = date($format, strtotime($model->$key));
		}
		return Html::maketag('input', true, array_merge([
			'type' => 'text',
			'name' => get_class($model) . '[' . $key . ']',
			'value' => $date
		], $options));
	}

	public static function activeCombo($model, $key, $values = [], $options = [])
	{
		$ret = Html::maketag('select', true, array_merge([
			'name' => get_class($model) . '[' . $key . ']'
		], $options));
		foreach($values as $k => $v) {
			$selected = '';
			if(is_int($k)) {
				if($model->$key == $v) {
					$selected = ' selected';
				}
				$ret .= '<option value="' . $v . '"' . $selected . '>' . $v . '</option>';
			} else {
				if($model->$key == $k) {
					$selected = ' selected';
				}
				$ret .= '<option value="' . $k . '"' . $selected . '>' . $v . '</option>';
			}
		}
		$ret .= '</select>';
		return $ret;
	}

	public static function activeCheck($model, $key, $options = [], $on = '1', $off = '0')
	{
		$checked = '';
		if($model->$key == $on) {
			$checked = 'checked';
		}
		$fieldname = get_class($model) . '[' . $key . ']';
		return Html::maketag('input', true, [
			'type' => 'hidden',
			'name' => $fieldname,
			'value' => $off,
		]) . Html::maketag('input', true, array_merge([
			'type' => 'checkbox',
			'name' => $fieldname,
			'value' => $on,
			$checked
		], $options));
	}
}
