@extends('layouts.app')

@section('content')
    <style>
        .diferencia-aceptable {
            background-color: green;
            color: white;
        }

        .diferencia-moderada {
            background-color: yellow;
            color: black;
        }

        .diferencia-inaceptable {
            background-color: red;
            color: white;
        }
    </style>
    <div class="container mt-5">
        <h2>Comparar Neumáticos</h2>
        <form id="comparar-neumaticos">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="medida2">Medida 1</label>
                    <select id="medida2" class="form-control">
                        <!-- Opciones de medidas de llantas -->
                        <option value="175-70-13">175-70-13</option>
                        <option value="185-70-13">185-70-13</option>
                        <option value="195-60-13">195-60-13</option>
                        <option value="205-60-13">205-60-13</option>
                        <option value="175-65-14">175-65-14</option>
                        <option value="185-65-14">185-65-14</option>
                        <option value="195-60-14">195-60-14</option>
                        <option value="195-65-14">195-65-14</option>
                        <option value="205-60-14">205-60-14</option>
                        <option value="205-65-14">205-65-14</option>
                        <option value="215-60-14">215-60-14</option>
                        <option value="215-65-14">215-65-14</option>
                        <option value="225-60-14">225-60-14</option>
                        <option value="225-65-14">225-65-14</option>
                        <option value="185-70-14">185-70-14</option>
                        <option value="195-70-14">195-70-14</option>
                        <option value="205-70-14">205-70-14</option>
                        <option value="215-70-14">215-70-14</option>
                        <option value="225-70-14">225-70-14</option>
                        <option value="205-75-14">205-75-14</option>
                        <option value="215-75-14">215-75-14</option>
                        <option value="175-65-15">175-65-15</option>
                        <option value="175-70-15">175-70-15</option>
                        <option value="185-60-15">185-60-15</option>
                        <option value="185-65-15">185-65-15</option>
                        <option value="195-55-15">195-55-15</option>
                        <option value="195-60-15">195-60-15</option>
                        <option value="195-65-15">195-65-15</option>
                        <option value="205-50-15">205-50-15</option>
                        <option value="205-55-15">205-55-15</option>
                        <option value="205-60-15">205-60-15</option>
                        <option value="205-65-15">205-65-15</option>
                        <option value="215-50-15">215-50-15</option>
                        <option value="215-55-15">215-55-15</option>
                        <option value="215-60-15">215-60-15</option>
                        <option value="215-65-15">215-65-15</option>
                        <option value="225-50-15">225-50-15</option>
                        <option value="225-55-15">225-55-15</option>
                        <option value="225-60-15">225-60-15</option>
                        <option value="225-65-15">225-65-15</option>
                        <option value="235-50-15">235-50-15</option>
                        <option value="235-55-15">235-55-15</option>
                        <option value="235-60-15">235-60-15</option>
                        <option value="235-75-15">235-75-15</option>
                        <option value="245-75-15">245-75-15</option>
                        <option value="255-70-15">255-70-15</option>
                        <option value="265-70-15">265-70-15</option>
                        <option value="266.7-80.01-15">31-10.50-15</option>
                        <option value="317.5-101.6-15">32-12.50-15</option>
                        <option value="317.5-104.775-15">33-12.50-15</option>
                        <option value="317.5-111.125-15">35-12.50-15</option>
                        <option value="317.5-117.475-15">37-12.50-15</option>
                        <option value="185-55-16">185-55-16</option>
                        <option value="195-50-16">195-50-16</option>
                        <option value="195-55-16">195-55-16</option>
                        <option value="205-45-16">205-45-16</option>
                        <option value="205-50-16">205-50-16</option>
                        <option value="205-55-16">205-55-16</option>
                        <option value="215-45-16">215-45-16</option>
                        <option value="215-50-16">215-50-16</option>
                        <option value="215-55-16">215-55-16</option>
                        <option value="225-45-16">225-45-16</option>
                        <option value="225-50-16">225-50-16</option>
                        <option value="225-55-16">225-55-16</option>
                        <option value="235-45-16">235-45-16</option>
                        <option value="235-50-16">235-50-16</option>
                        <option value="235-55-16">235-55-16</option>
                        <option value="245-45-16">245-45-16</option>
                        <option value="245-50-16">245-50-16</option>
                        <option value="255-45-16">255-45-16</option>
                        <option value="265-45-16">265-45-16</option>
                        <option value="275-45-16">275-45-16</option>
                        <option value="285-45-16">285-45-16</option>
                        <option value="266.7-80.01-16">31-10.50-16</option>
                        <option value="317.5-101.6-16">32-12.50-16</option>
                        <option value="317.5-104.775-16">33-12.50-16</option>
                        <option value="317.5-111.125-16">35-12.50-16</option>
                        <option value="317.5-117.475-16">37-12.50-16</option>
                        <option value="195-40-17">195-40-17</option>
                        <option value="195-45-17">195-45-17</option>
                        <option value="195-50-17">195-50-17</option>
                        <option value="205-40-17">205-40-17</option>
                        <option value="205-45-17">205-45-17</option>
                        <option value="205-50-17">205-50-17</option>
                        <option value="205-55-17">205-55-17</option>
                        <option value="215-40-17">215-40-17</option>
                        <option value="215-45-17">215-45-17</option>
                        <option value="215-50-17">215-50-17</option>
                        <option value="215-55-17">215-55-17</option>
                        <option value="225-40-17">225-40-17</option>
                        <option value="225-45-17">225-45-17</option>
                        <option value="225-50-17">225-50-17</option>
                        <option value="225-55-17">225-55-17</option>
                        <option value="235-40-17">235-40-17</option>
                        <option value="235-45-17">235-45-17</option>
                        <option value="235-50-17">235-50-17</option>
                        <option value="235-55-17">235-55-17</option>
                        <option value="245-40-17">245-40-17</option>
                        <option value="245-45-17">245-45-17</option>
                        <option value="255-40-17">255-40-17</option>
                        <option value="255-45-17">255-45-17</option>
                        <option value="265-40-17">265-40-17</option>
                        <option value="265-45-17">265-45-17</option>
                        <option value="275-40-17">275-40-17</option>
                        <option value="275-45-17">275-45-17</option>
                        <option value="285-40-17">285-40-17</option>
                        <option value="266.7-80.01-17">31-10.50-17</option>
                        <option value="317.5-101.6-17">32-12.50-17</option>
                        <option value="317.5-104.775-17">33-12.50-17</option>
                        <option value="317.5-111.125-17">35-12.50-17</option>
                        <option value="317.5-117.475-17">37-12.50-17</option>
                        <option value="205-50-18">205-50-18</option>
                        <option value="205-55-18">205-55-18</option>
                        <option value="215-40-18">215-40-18</option>
                        <option value="215-45-18">215-45-18</option>
                        <option value="215-50-18">215-50-18</option>
                        <option value="215-55-18">215-55-18</option>
                        <option value="225-40-18">225-40-18</option>
                        <option value="225-45-18">225-45-18</option>
                        <option value="225-50-18">225-50-18</option>
                        <option value="225-55-18">225-55-18</option>
                        <option value="235-40-18">235-40-18</option>
                        <option value="235-45-18">235-45-18</option>
                        <option value="235-50-18">235-50-18</option>
                        <option value="235-55-18">235-55-18</option>
                        <option value="245-40-18">245-40-18</option>
                        <option value="245-45-18">245-45-18</option>
                        <option value="255-40-18">255-40-18</option>
                        <option value="255-45-18">255-45-18</option>
                        <option value="265-35-18">265-35-18</option>
                        <option value="265-40-18">265-40-18</option>
                        <option value="275-35-18">275-35-18</option>
                        <option value="275-40-18">275-40-18</option>
                        <option value="285-35-18">285-35-18</option>
                        <option value="285-40-18">285-40-18</option>
                        <option value="215-35-19">215-35-19</option>
                        <option value="215-40-19">215-40-19</option>
                        <option value="215-45-19">215-45-19</option>
                        <option value="215-50-19">215-50-19</option>
                        <option value="225-35-19">225-35-19</option>
                        <option value="225-40-19">225-40-19</option>
                        <option value="225-45-19">225-45-19</option>
                        <option value="225-50-19">225-50-19</option>
                        <option value="235-35-19">235-35-19</option>
                        <option value="235-40-19">235-40-19</option>
                        <option value="235-45-19">235-45-19</option>
                        <option value="235-50-19">235-50-19</option>
                        <option value="245-35-19">245-35-19</option>
                        <option value="245-40-19">245-40-19</option>
                        <option value="255-30-19">255-30-19</option>
                        <option value="255-35-19">255-35-19</option>
                        <option value="255-40-19">255-40-19</option>
                        <option value="265-30-19">265-30-19</option>
                        <option value="265-35-19">265-35-19</option>
                        <option value="275-30-19">275-30-19</option>
                        <option value="275-35-19">275-35-19</option>
                        <option value="215-30-20">215-30-20</option>
                        <option value="215-35-20">215-35-20</option>
                        <option value="215-40-20">215-40-20</option>
                        <option value="225-30-20">225-30-20</option>
                        <option value="225-35-20">225-35-20</option>
                        <option value="225-40-20">225-40-20</option>
                        <option value="235-30-20">235-30-20</option>
                        <option value="235-35-20">235-35-20</option>
                        <option value="235-40-20">235-40-20</option>
                        <option value="245-30-20">245-30-20</option>
                        <option value="245-35-20">245-35-20</option>
                        <option value="255-30-20">255-30-20</option>
                        <option value="255-35-20">255-35-20</option>
                        <option value="265-30-20">265-30-20</option>
                        <option value="275-25-20">275-25-20</option>
                        <option value="275-30-20">275-30-20</option>
                        <option value="285-25-20">285-25-20</option>
                        <option value="285-30-20">285-30-20</option>
                        <option value="295-25-20">295-25-20</option>
                        <option value="305-40-20">305-40-20</option>
                        <option value="245-30-22">245-30-22</option>
                        <option value="255-25-22">255-25-22</option>
                        <option value="255-30-22">255-30-22</option>
                        <option value="265-25-22">265-25-22</option>
                        <option value="265-30-22">265-30-22</option>
                        <option value="275-25-22">275-25-22</option>
                        <option value="285-25-22">285-25-22</option>
                        <option value="295-25-22">295-25-22</option>
                        <option value="305-40-22">305-40-22</option>
                        <option value="305-45-22">305-45-22</option>
                        <option value="315-40-22">315-40-22</option>
                        <option value="305-35-24">305-35-24</option>
                        <option value="305-40-24">305-40-24</option>
                        <option value="315-35-24">315-35-24</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="medida1">Medida 2</label>
                    <select id="medida1" class="form-control">
                        <!-- Opciones de medidas de llantas -->
                        <option value="175-70-13">175-70-13</option>
                        <option value="185-70-13">185-70-13</option>
                        <option value="195-60-13">195-60-13</option>
                        <option value="205-60-13">205-60-13</option>
                        <option value="175-65-14">175-65-14</option>
                        <option value="185-65-14">185-65-14</option>
                        <option value="195-60-14">195-60-14</option>
                        <option value="195-65-14">195-65-14</option>
                        <option value="205-60-14">205-60-14</option>
                        <option value="205-65-14">205-65-14</option>
                        <option value="215-60-14">215-60-14</option>
                        <option value="215-65-14">215-65-14</option>
                        <option value="225-60-14">225-60-14</option>
                        <option value="225-65-14">225-65-14</option>
                        <option value="185-70-14">185-70-14</option>
                        <option value="195-70-14">195-70-14</option>
                        <option value="205-70-14">205-70-14</option>
                        <option value="215-70-14">215-70-14</option>
                        <option value="225-70-14">225-70-14</option>
                        <option value="205-75-14">205-75-14</option>
                        <option value="215-75-14">215-75-14</option>
                        <option value="175-65-15">175-65-15</option>
                        <option value="175-70-15">175-70-15</option>
                        <option value="185-60-15">185-60-15</option>
                        <option value="185-65-15">185-65-15</option>
                        <option value="195-55-15">195-55-15</option>
                        <option value="195-60-15">195-60-15</option>
                        <option value="195-65-15">195-65-15</option>
                        <option value="205-50-15">205-50-15</option>
                        <option value="205-55-15">205-55-15</option>
                        <option value="205-60-15">205-60-15</option>
                        <option value="205-65-15">205-65-15</option>
                        <option value="215-50-15">215-50-15</option>
                        <option value="215-55-15">215-55-15</option>
                        <option value="215-60-15">215-60-15</option>
                        <option value="215-65-15">215-65-15</option>
                        <option value="225-50-15">225-50-15</option>
                        <option value="225-55-15">225-55-15</option>
                        <option value="225-60-15">225-60-15</option>
                        <option value="225-65-15">225-65-15</option>
                        <option value="235-50-15">235-50-15</option>
                        <option value="235-55-15">235-55-15</option>
                        <option value="235-60-15">235-60-15</option>
                        <option value="235-75-15">235-75-15</option>
                        <option value="245-75-15">245-75-15</option>
                        <option value="255-70-15">255-70-15</option>
                        <option value="265-70-15">265-70-15</option>
                        <option value="266.7-80.01-15">31-10.50-15</option>
                        <option value="317.5-101.6-15">32-12.50-15</option>
                        <option value="317.5-104.775-15">33-12.50-15</option>
                        <option value="317.5-111.125-15">35-12.50-15</option>
                        <option value="317.5-117.475-15">37-12.50-15</option>
                        <option value="185-55-16">185-55-16</option>
                        <option value="195-50-16">195-50-16</option>
                        <option value="195-55-16">195-55-16</option>
                        <option value="205-45-16">205-45-16</option>
                        <option value="205-50-16">205-50-16</option>
                        <option value="205-55-16">205-55-16</option>
                        <option value="215-45-16">215-45-16</option>
                        <option value="215-50-16">215-50-16</option>
                        <option value="215-55-16">215-55-16</option>
                        <option value="225-45-16">225-45-16</option>
                        <option value="225-50-16">225-50-16</option>
                        <option value="225-55-16">225-55-16</option>
                        <option value="235-45-16">235-45-16</option>
                        <option value="235-50-16">235-50-16</option>
                        <option value="235-55-16">235-55-16</option>
                        <option value="245-45-16">245-45-16</option>
                        <option value="245-50-16">245-50-16</option>
                        <option value="255-45-16">255-45-16</option>
                        <option value="265-45-16">265-45-16</option>
                        <option value="275-45-16">275-45-16</option>
                        <option value="285-45-16">285-45-16</option>
                        <option value="266.7-80.01-16">31-10.50-16</option>
                        <option value="317.5-101.6-16">32-12.50-16</option>
                        <option value="317.5-104.775-16">33-12.50-16</option>
                        <option value="317.5-111.125-16">35-12.50-16</option>
                        <option value="317.5-117.475-16">37-12.50-16</option>
                        <option value="195-40-17">195-40-17</option>
                        <option value="195-45-17">195-45-17</option>
                        <option value="195-50-17">195-50-17</option>
                        <option value="205-40-17">205-40-17</option>
                        <option value="205-45-17">205-45-17</option>
                        <option value="205-50-17">205-50-17</option>
                        <option value="205-55-17">205-55-17</option>
                        <option value="215-40-17">215-40-17</option>
                        <option value="215-45-17">215-45-17</option>
                        <option value="215-50-17">215-50-17</option>
                        <option value="215-55-17">215-55-17</option>
                        <option value="225-40-17">225-40-17</option>
                        <option value="225-45-17">225-45-17</option>
                        <option value="225-50-17">225-50-17</option>
                        <option value="225-55-17">225-55-17</option>
                        <option value="235-40-17">235-40-17</option>
                        <option value="235-45-17">235-45-17</option>
                        <option value="235-50-17">235-50-17</option>
                        <option value="235-55-17">235-55-17</option>
                        <option value="245-40-17">245-40-17</option>
                        <option value="245-45-17">245-45-17</option>
                        <option value="255-40-17">255-40-17</option>
                        <option value="255-45-17">255-45-17</option>
                        <option value="265-40-17">265-40-17</option>
                        <option value="265-45-17">265-45-17</option>
                        <option value="275-40-17">275-40-17</option>
                        <option value="275-45-17">275-45-17</option>
                        <option value="285-40-17">285-40-17</option>
                        <option value="266.7-80.01-17">31-10.50-17</option>
                        <option value="317.5-101.6-17">32-12.50-17</option>
                        <option value="317.5-104.775-17">33-12.50-17</option>
                        <option value="317.5-111.125-17">35-12.50-17</option>
                        <option value="317.5-117.475-17">37-12.50-17</option>
                        <option value="205-50-18">205-50-18</option>
                        <option value="205-55-18">205-55-18</option>
                        <option value="215-40-18">215-40-18</option>
                        <option value="215-45-18">215-45-18</option>
                        <option value="215-50-18">215-50-18</option>
                        <option value="215-55-18">215-55-18</option>
                        <option value="225-40-18">225-40-18</option>
                        <option value="225-45-18">225-45-18</option>
                        <option value="225-50-18">225-50-18</option>
                        <option value="225-55-18">225-55-18</option>
                        <option value="235-40-18">235-40-18</option>
                        <option value="235-45-18">235-45-18</option>
                        <option value="235-50-18">235-50-18</option>
                        <option value="235-55-18">235-55-18</option>
                        <option value="245-40-18">245-40-18</option>
                        <option value="245-45-18">245-45-18</option>
                        <option value="255-40-18">255-40-18</option>
                        <option value="255-45-18">255-45-18</option>
                        <option value="265-35-18">265-35-18</option>
                        <option value="265-40-18">265-40-18</option>
                        <option value="275-35-18">275-35-18</option>
                        <option value="275-40-18">275-40-18</option>
                        <option value="285-35-18">285-35-18</option>
                        <option value="285-40-18">285-40-18</option>
                        <option value="215-35-19">215-35-19</option>
                        <option value="215-40-19">215-40-19</option>
                        <option value="215-45-19">215-45-19</option>
                        <option value="215-50-19">215-50-19</option>
                        <option value="225-35-19">225-35-19</option>
                        <option value="225-40-19">225-40-19</option>
                        <option value="225-45-19">225-45-19</option>
                        <option value="225-50-19">225-50-19</option>
                        <option value="235-35-19">235-35-19</option>
                        <option value="235-40-19">235-40-19</option>
                        <option value="235-45-19">235-45-19</option>
                        <option value="235-50-19">235-50-19</option>
                        <option value="245-35-19">245-35-19</option>
                        <option value="245-40-19">245-40-19</option>
                        <option value="255-30-19">255-30-19</option>
                        <option value="255-35-19">255-35-19</option>
                        <option value="255-40-19">255-40-19</option>
                        <option value="265-30-19">265-30-19</option>
                        <option value="265-35-19">265-35-19</option>
                        <option value="275-30-19">275-30-19</option>
                        <option value="275-35-19">275-35-19</option>
                        <option value="215-30-20">215-30-20</option>
                        <option value="215-35-20">215-35-20</option>
                        <option value="215-40-20">215-40-20</option>
                        <option value="225-30-20">225-30-20</option>
                        <option value="225-35-20">225-35-20</option>
                        <option value="225-40-20">225-40-20</option>
                        <option value="235-30-20">235-30-20</option>
                        <option value="235-35-20">235-35-20</option>
                        <option value="235-40-20">235-40-20</option>
                        <option value="245-30-20">245-30-20</option>
                        <option value="245-35-20">245-35-20</option>
                        <option value="255-30-20">255-30-20</option>
                        <option value="255-35-20">255-35-20</option>
                        <option value="265-30-20">265-30-20</option>
                        <option value="275-25-20">275-25-20</option>
                        <option value="275-30-20">275-30-20</option>
                        <option value="285-25-20">285-25-20</option>
                        <option value="285-30-20">285-30-20</option>
                        <option value="295-25-20">295-25-20</option>
                        <option value="305-40-20">305-40-20</option>
                        <option value="245-30-22">245-30-22</option>
                        <option value="255-25-22">255-25-22</option>
                        <option value="255-30-22">255-30-22</option>
                        <option value="265-25-22">265-25-22</option>
                        <option value="265-30-22">265-30-22</option>
                        <option value="275-25-22">275-25-22</option>
                        <option value="285-25-22">285-25-22</option>
                        <option value="295-25-22">295-25-22</option>
                        <option value="305-40-22">305-40-22</option>
                        <option value="305-45-22">305-45-22</option>
                        <option value="315-40-22">315-40-22</option>
                        <option value="305-35-24">305-35-24</option>
                        <option value="305-40-24">305-40-24</option>
                        <option value="315-35-24">315-35-24</option>
                        <!-- Agrega más opciones según sea necesario -->
                    </select>
                </div>
            </div>
        </form>
        <div class="d-flex justify-content-center align-items-center">
            <canvas id="llantaCanvas" height="600" width="600"></canvas>
        </div>



        <table class="table table-hover mt-4">
            <thead>
                <tr>
                    <th width="200px;">Parámetro</th>
                    <th>Medida 1</th>
                    <th>Medida 2</th>
                    <th>Diferencia</th>
                </tr>
            </thead>
            <tbody id="resultado-comparacion">
                <!-- Resultados de la comparación -->
            </tbody>
        </table>
        <br>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const medida1 = document.getElementById('medida1');
            const medida2 = document.getElementById('medida2');

            medida1.addEventListener('change', actualizarComparacion);
            medida2.addEventListener('change', actualizarComparacion);

            const PERCENTAGE_THRESHOLD_ACCEPTABLE = 0.03; // Umbral aceptable del 3%
            const PERCENTAGE_THRESHOLD_MODERATE = 0.05; // Umbral moderado del 5%

            function obtenerDimensiones(medida) {
                const [ancho, perfil, rin] = medida.split('-');
                const anchoNum = parseFloat(ancho);
                const perfilNum = parseFloat(perfil);
                const rinNum = parseFloat(rin);

                const anchocm = anchoNum / 10;
                const altura = (anchoNum * perfilNum) / 100;
                const alturacm = altura / 10;
                const diametroRin = rinNum * 25.4; // Convertimos el rin a mm
                const diametroTotal = altura * 2 + diametroRin;

                return {
                    ancho: anchoNum,
                    altura,
                    diametroTotal,
                    diametroRin,
                    anchocm,
                    alturacm
                };
            }

            function actualizarComparacion() {
                const dimensiones1 = obtenerDimensiones(medida1.value);
                const dimensiones2 = obtenerDimensiones(medida2.value);

                const diferenciaAnchoCm = (Math.abs(dimensiones1.ancho - dimensiones2.ancho) / 10).toFixed(2);
                const diferenciaAlturaCm = (Math.abs(dimensiones1.altura - dimensiones2.altura) / 10).toFixed(2);
                const diferenciaDiametroCm = (Math.abs(dimensiones1.diametroTotal - dimensiones2.diametroTotal) /
                    10).toFixed(2);
                const diferenciaTotalAlturaCm = (Math.abs(dimensiones1.diametroTotal - dimensiones2.diametroTotal) /
                    10).toFixed(2);

                let claseDiferencia = '';
                const umbralDiferenciaMm = dimensiones1.diametroTotal * PERCENTAGE_THRESHOLD_ACCEPTABLE;
                const umbralModeradoMm = dimensiones1.diametroTotal * PERCENTAGE_THRESHOLD_MODERATE;

                if (diferenciaTotalAlturaCm <= umbralDiferenciaMm / 10) {
                    claseDiferencia = 'diferencia-aceptable';
                } else if (diferenciaTotalAlturaCm <= umbralModeradoMm / 10) {
                    claseDiferencia = 'diferencia-moderada';
                } else {
                    claseDiferencia = 'diferencia-inaceptable';
                }

                const resultadoHTML = `
                    <tr>
                        <td>Ancho</td>
                        <td>${dimensiones2.ancho} mm | ${dimensiones2.anchocm} cm</td>
                        <td>${dimensiones1.ancho} mm | ${dimensiones1.anchocm} cm</td>
                        <td>${diferenciaAnchoCm} cm</td>
                    </tr>
                    <tr>
                        <td>Altura</td>
                        <td>${dimensiones2.altura.toFixed(2)} mm | ${dimensiones2.alturacm} cm</td>
                        <td>${dimensiones1.altura.toFixed(2)} mm | ${dimensiones1.alturacm} cm</td>
                        <td>${diferenciaAlturaCm} cm</td>
                    </tr>
                    <tr>
                        <td>Diámetro</td>
                        <td>${dimensiones2.diametroTotal.toFixed(2)} mm</td>
                        <td>${dimensiones1.diametroTotal.toFixed(2)} mm</td>
                        <td>${diferenciaDiametroCm} cm</td>
                    </tr>
                    <tr>
                        <td>Diferencia Total de Altura (Incluyendo Rin)</td>
                        <td colspan="2"></td>
                        <td class="${claseDiferencia}">${diferenciaTotalAlturaCm} cm</td>
                    </tr>
                `;

                document.getElementById('resultado-comparacion').innerHTML = resultadoHTML;

                // Actualizar el dibujo de la llanta
                dibujarLlanta(dimensiones1, dimensiones2);
            }

            function dibujarLlanta(dim1, dim2) {
                const canvas = document.getElementById('llantaCanvas');
                const ctx = canvas.getContext('2d');
                ctx.clearRect(0, 0, canvas.width, canvas.height);

                // Calcula los radios
                const radioTotal1 = dim1.diametroTotal / 4;
                const radioRin1 = dim1.diametroRin / 4;
                const radioTotal2 = dim2.diametroTotal / 4;
                const radioRin2 = dim2.diametroRin / 4;

                // Coordenadas del centro
                const centerX = canvas.width / 2;
                const centerY = canvas.height / 2;

                // Dibujar el semicírculo para el rin (medida 1)


                // Dibujar el borde del neumático (medida 1)
                ctx.beginPath();
                ctx.arc(centerX, centerY, radioTotal1, Math.PI / 2, 3 * Math.PI / 2, true);
                ctx.lineTo(centerX, centerY - radioTotal1);
                ctx.arc(centerX, centerY, radioRin1, 3 * Math.PI / 2, Math.PI / 2, false);
                ctx.lineTo(centerX, centerY + radioRin1);
                ctx.fillStyle = 'black'; // Color negro para el neumático
                ctx.fill();
                ctx.closePath();

                // Dibujar el semicírculo para el rin (medida 2)


                // Dibujar el borde del neumático (medida 2)
                ctx.beginPath();
                ctx.arc(centerX, centerY, radioTotal2, 3 * Math.PI / 2, Math.PI / 2, true);
                ctx.lineTo(centerX, centerY + radioTotal2);
                ctx.arc(centerX, centerY, radioRin2, Math.PI / 2, 3 * Math.PI / 2, false);
                ctx.lineTo(centerX, centerY - radioRin2);
                ctx.fillStyle = 'black'; // Color negro para el neumático
                ctx.fill();
                ctx.closePath();
            }

            actualizarComparacion();
        });
    </script>
@endsection
