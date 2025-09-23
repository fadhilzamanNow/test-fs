import { startLoading, stopLoading } from '../store/loading'
import http from './axios'

export async function getAllOrderLogs(perPage: number, page: number, q = '') {
  try {
    startLoading()
    const { data } = await http.get('/order-logs', {
      params: { perPage, page, q },
    })
    return data // expect { data, total }
  } catch (err: any) {
    throw new Error(err?.response?.data?.message ?? 'Gagal mengambil order logs')
  } finally {
    stopLoading()
  }
}

export async function getOrderLogsByOrderId(orderId: string) {
  try {
    startLoading()
    const { data } = await http.get('/order-logs', {
      params: { order_id: orderId },
    })
    return data // { data, total, ... }
  } catch (err: any) {
    throw new Error(err?.response?.data?.message ?? 'Gagal mengambil log order')
  } finally {
    stopLoading()
  }
}

export async function getOrderLog(id: string) {
  try {
    const { data } = await http.get(`/order-logs/${id}`)
    return data
  } catch (err: any) {
    throw new Error(err?.response?.data?.message ?? 'Gagal mengambil detail log')
  }
}