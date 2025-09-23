import http from './axios'

import { startLoading, stopLoading } from '../store/loading'

export async function getAllPlans(
  itemRows: number,
  currentPage: number,
  search: string = ''
) {
  try {
    startLoading()
    const { data } = await http.get('/plans', {
      params: {
        perPage: itemRows,
        page: currentPage,
        search: search,
      },
    })
    return data
  } catch (err: any) {
    throw new Error(err?.response?.data?.message ?? 'Gagal mengambil daftar rencana produksi')
  } finally {
    stopLoading()
  }
}

export async function createPlan(payload: {
  plan_name: string
  product_id: string
  quantity: number
  due_date?: string | null
}) {
  try {
    startLoading()
    const { data } = await http.post('/plans', payload)
    return data
  } catch (err: any) {
    throw new Error(err?.response?.data?.message ?? 'Gagal membuat rencana produksi')
  } finally {
    stopLoading()
  }
}

export async function getPlan(id: string | number) {
  try {
    startLoading()
    const { data } = await http.get(`/plans/${id}`)
    return data
  } catch (err: any) {
    throw new Error(err?.response?.data?.message ?? 'Gagal mengambil detail rencana produksi')
  } finally {
    stopLoading()
  }
}

export async function updatePlan(
  id: string | number,
  payload: Partial<{
    plan_name: string
    product_id: string
    quantity: number
    due_date?: string | null
  }>
) {
  try {
    startLoading()
    const { data } = await http.put(`/plans/${id}`, payload)
    return data
  } catch (err: any) {
    throw new Error(err?.response?.data?.message ?? 'Gagal memperbarui rencana produksi')
  } finally {
    stopLoading()
  }
}

export async function deletePlan(id: string | number) {
  try {
    startLoading()
    const { data } = await http.delete(`/plans/${id}`)
    return data
  } catch (err: any) {
    throw new Error(err?.response?.data?.message ?? 'Gagal menghapus rencana produksi')
  } finally {
    stopLoading()
  }
}

export async function changePlanStatus(
  id: string | number,
  status: 'waiting' | 'approved' | 'rejected',
  notes : string = ""
) {
  try {
    startLoading()
    const { data } = await http.patch(`/plans/${id}/status`, { status, notes })
    return data
  } catch (err: any) {
    throw new Error(err?.response?.data?.message ?? 'Gagal mengubah status rencana produksi')
  } finally {
    stopLoading()
  }
}
