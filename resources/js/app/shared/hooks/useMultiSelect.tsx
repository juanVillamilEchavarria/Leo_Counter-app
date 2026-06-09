/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import React, {useCallback } from 'react';
import { addUniqueItem, removeItemById } from '@/app/shared/helpers';

interface useMultiSelectProps<T extends { id: number | string }> {
  items?: T[];
  setItems: (items: T[]) => void;
}
export function useMultiSelect<T extends { id: number | string }>({
  items = [],
   setItems 
  }: useMultiSelectProps<T>) {
  const addItem = useCallback((item: T) => {
    setItems(addUniqueItem(item, items));
  }, [items, setItems]);

  const removeItem = useCallback((id: number | string) => {
    setItems(removeItemById(id, items));
  }, [items, setItems]);

  const clearItems = useCallback(() => {
    setItems([]);
  }, [setItems]);

  return {
    items,
    addItem,
    removeItem,
    clearItems,
    setItems,
  };
}