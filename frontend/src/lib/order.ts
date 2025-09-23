import http from './axios'
import { startLoading, stopLoading } from '../store/loading'
import type { OrderStatus } from './utils'
export async function getAllOrders(perPage: number, page: number, q = '') {
  try {
    startLoading()
    const { data } = await http.get('/orders', { params: { perPage, page, q } })
    return data // expect { data, total }
  } catch (err: any) {
    throw new Error(err?.response?.data?.message ?? 'Gagal mengambil daftar order')
  } finally {
    stopLoading()
  }
}

export async function createOrder(payload: {
  plan_id: string
  quantity: number
  // optionally: order_no?: string
}) {
  try {
    startLoading()
    const { data } = await http.post('/orders', payload)
    return data
  } catch (err: any) {
    throw new Error(err?.response?.data?.message ?? 'Gagal membuat order')
  } finally {
    stopLoading()
  }
}

export async function getOrder(id: string) {
  try {
    startLoading()
    const { data } = await http.get(`/orders/${id}`)
    return data
  } catch (err: any) {
    throw new Error(err?.response?.data?.message ?? 'Gagal mengambil detail order')
  } finally {
    stopLoading()
  }
}

export async function updateOrder(
  id: string,
  payload: Partial<{ plan_id: string; quantity: number; status: OrderStatus }>
) {
  try {
    startLoading()
    const { data } = await http.put(`/orders/${id}`, payload)
    return data
  } catch (err: any) {
    throw new Error(err?.response?.data?.message ?? 'Gagal memperbarui order')
  } finally {
    stopLoading()
  }
}

export async function deleteOrder(id: string) {
  try {
    startLoading()
    const { data } = await http.delete(`/orders/${id}`)
    return data
  } catch (err: any) {
    throw new Error(err?.response?.data?.message ?? 'Gagal menghapus order')
  } finally {
    stopLoading()
  }
}

export async function changeOrderStatus(id: string, status: OrderStatus) {
  try {
    startLoading()
    const { data } = await http.post(`/orders/${id}/status`, { status })
    return data
  } catch (err: any) {
    throw new Error(err?.response?.data?.message ?? 'Gagal mengubah status order')
  } finally {
    stopLoading()
  }
}