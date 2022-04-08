# encording: utf-8

p "あなたの身長を教えてください(cmで入力)"

height_m = gets.chomp.to_f / 100

p "あなたの体重を教えてください(kgで入力)"

weight = gets.chomp.to_i

# 小数点第何位まで求めるか
dec = 2

# 入力された身長をmに換算(5行目にまとめられた)
#height_m = height /100

# BMIの計算をして変数に入れる
bmi = ( weight / ( height_m ** 2 ) ).round(dec)

# BMIの数値に合った言葉を変数に入れる
standard = 
if bmi < 18.5
  "低体重"
elsif bmi >=18.5 && bmi <25
  "普通体重"
else
  "肥満"
end

# 適正体重の計算
standard2 = ((height_m ** 2) * 22).round(dec)

# 出力
puts "-------------------------------------"
puts "あなたのBMIは、#{bmi}です。"
puts "あなたは、#{standard}です。"
puts "あなたの適正体重は、#{standard2}kgです。"